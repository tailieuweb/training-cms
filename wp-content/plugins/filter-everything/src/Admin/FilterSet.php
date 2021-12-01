<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class FilterSet
{
    const NONCE_ACTION = 'wpc-f-set-nonce';

    const FIELD_NAME_PREFIX = 'wpc_set_fields';

    private $defaultFields = [];

    private $hooksRegistered = false;

    private $errors;

    public function __construct()
    {
        $this->registerHooks();
    }

    private function setupDefaultFields()
    {
        // maybe add filter in future to allow change default fields
        $defaultFields = array(
            'wp_page_type' => array(
                'type'          => 'Hidden',
                'label'         => esc_html__('Location', 'filter-everything'),
                'class'         => 'wpc-field-wp-page-type',
                'id'            => $this->generateFieldId('wp_page_type'),
                'name'          => $this->generateFieldName('wp_page_type'),
                'default'       => 'common___common',
                'instructions'  => esc_html__('Specify page(s) where to show this Filter Set', 'filter-everything'),
                'settings'      => true
            ),
            'post_type' => array(
                'type'          => 'Select',
                'label'         => esc_html__('Post Type to filter', 'filter-everything'),
                'name'          => $this->generateFieldName('post_type'),
                'id'            => $this->generateFieldId('post_type'),
                'class'         => 'wpc-field-post-type',
                'options'       => $this->getPostTypes(),
                'default'       => 'post',
                'instructions'  => esc_html__('Select Post Type you need to filter', 'filter-everything'),
                'particular'    => 'post_excerpt' // Determine that this is specific field should be stored in wp_post column
            ),
            'post_name' => array(
                'type'          => 'Hidden',
                'label'         => '',
                'name'          => $this->generateFieldName('post_name'),
                'id'            => $this->generateFieldId('post_name'),
                'class'         => 'wpc-field-location',
                'default'       => '1',
                'instructions'  => esc_html__('Specify page(s) where to show this Filter Set', 'filter-everything'),
                'particular'    => 'post_name',
                'settings'      => true
            ),
            'wp_filter_query' => array(
                'type'          => 'Hidden',
                'label'         => esc_html__('Query', 'filter-everything'),
                'class'         => 'wpc-field-wp-filter-query',
                'id'            => $this->generateFieldId('wp_filter_query'),
                'name'          => $this->generateFieldName('wp_filter_query'),
                'options'       => '',
                'default'       => '-1',
                'instructions'  => esc_html__('Select WP Query, that should be filtered', 'filter-everything'),
                'settings'      => true
            ),
            'hide_empty' => array(
                'type'          => 'Select',
                'label'         => esc_html__('Empty Terms', 'filter-everything'),
                'name'          => $this->generateFieldName('hide_empty'),
                'id'            => $this->generateFieldId('hide_empty'),
                'class'         => 'wpc-field-hide-empty',
                'options'       => array(
                    'no' => esc_html__('Never hide', 'filter-everything'),
                    'yes' => esc_html__('Always hide', 'filter-everything'),
                    'initial' => esc_html__('Hide in the initial Filter only', 'filter-everything')
                ),
                'default'       => 'yes',
                'instructions'  => esc_html__('To hide or not a Filter terms that do not contain posts', 'filter-everything'),
                'settings'      => true
            ),
            'show_count' => array(
                'type'          => 'Checkbox',
                'label'         => esc_html__('Show count', 'filter-everything'),
                'name'          => $this->generateFieldName('show_count'),
                'id'            => $this->generateFieldId('show_count'),
                'class'         => 'wpc-field-show-count',
                'default'       => 'yes',
                'instructions'  => esc_html__('Display number of posts in a term', 'filter-everything'),
                'settings'      => true
            )

        );

        $this->defaultFields = apply_filters( 'wpc_filter_set_default_fields', $defaultFields, $this );
    }

    private function registerHooks()
    {
        if (!$this->hooksRegistered) {
            add_filter('wpc_input_type_select', array($this, 'addCustomLabel'), 10, 2);
            add_action('admin_print_scripts', array($this, 'includeAdminJs'), 9999);

            add_filter( 'post_updated_messages', [$this, 'filterSetActionsMessages'] );
            add_filter( 'bulk_post_updated_messages', [ $this, 'filterSetBulkActionsMessages' ], 10, 2 );

            add_filter( 'page_row_actions', [$this, 'filterSetRowActions'], 10, 2 );

            add_action( 'restrict_manage_posts', [$this, 'restrictManagePosts'], 999 );

            $this->hooksRegistered = true;
        }
    }

    public function restrictManagePosts( $post_type )
    {
        if( $post_type === FLRT_FILTERS_SET_POST_TYPE ){
            $output = ob_get_clean();
            ob_start();
        }
    }

    public function filterSetRowActions( $actions, $post )
    {
        if( isset( $post->post_type ) && $post->post_type === FLRT_FILTERS_SET_POST_TYPE ){
            $new_actions = [];
            foreach( $actions as $key => $action ){
                if( in_array( $key, array( 'edit', 'trash', 'untrash', 'delete' ) ) ){
                    $new_actions[$key] = $action;
                }
            }
            return $new_actions;
        }
        return $actions;
    }

    public function filterSetBulkActionsMessages( $messages, $bulk_counts )
    {
        if( ! isset( $messages[ FLRT_FILTERS_SET_POST_TYPE ] ) ){
            $messages[ FLRT_FILTERS_SET_POST_TYPE ] = array(
                /* translators: %s: Number of posts. */
                'updated'   => esc_html( _n( '%s filter set updated.', '%s filter sets updated.', $bulk_counts['updated'], 'filter-everything' ) ),
                'locked'    => ( 1 === $bulk_counts['locked'] ) ? esc_html__( '1 filter set not updated, somebody is editing it.', 'filter-everything' ) :
                    /* translators: %s: Number of posts. */
                    esc_html( _n( '%s filter set not updated, somebody is editing it.', '%s filter sets not updated, somebody is editing them.', $bulk_counts['locked'], 'filter-everything' ) ),
                /* translators: %s: Number of posts. */
                'deleted'   => esc_html( _n( '%s filter set permanently deleted.', '%s filter sets permanently deleted.', $bulk_counts['deleted'], 'filter-everything' ) ),
                /* translators: %s: Number of posts. */
                'trashed'   => esc_html( _n( '%s filter set moved to the Trash.', '%s filter sets moved to the Trash.', $bulk_counts['trashed'], 'filter-everything' ) ),
                /* translators: %s: Number of posts. */
                'untrashed' => esc_html( _n( '%s filter set restored from the Trash.', '%s filter sets restored from the Trash.', $bulk_counts['untrashed'], 'filter-everything' ) ),
            );
        }
        return $messages;
    }

    public function filterSetActionsMessages( $messages )
    {
        if( ! isset( $messages[ FLRT_FILTERS_SET_POST_TYPE ] ) ){
            // No need to escape
            $messages[ FLRT_FILTERS_SET_POST_TYPE ] = array(
                0 => '',
                1 => esc_html__( 'Filters Set updated.', 'filter-everything' ),
                2 => esc_html__( 'Custom field updated.', 'filter-everything' ),
                3 => esc_html__( 'Custom field deleted.', 'filter-everything' ),
                4 => esc_html__( 'Filters Set updated.', 'filter-everything' ),
                5 => false,
                6 => esc_html__( 'Filter set created.', 'filter-everything' ),
                7 => esc_html__( 'Filter set saved.', 'filter-everything' ),
                8 => esc_html__( 'Filter set submitted.', 'filter-everything' ),
                9 => esc_html__( 'Filter set scheduled for', 'filter-everything' ),
                10 => esc_html__( 'Filter set draft updated.', 'filter-everything' ),
                // Errors
                11 => esc_html__('Filter set was not updated.', 'filter-everything')
            );
        }

        return $messages;
    }

    /**
     * @return array
     */
    private function getExistingFilterSlugs()
    {
        $existingSlugs = get_option('wpc_filter_permalinks', []);
        $convertedExistingSlugs = [];

        foreach( $existingSlugs as $entityKey => $slug ){
            $parts = explode( '#', $entityKey, 2 );
            $newEntityKey = implode('_', $parts);
            $convertedExistingSlugs[$newEntityKey] = $slug;
        }

        return $convertedExistingSlugs;
    }

    /**
     * @return array
     */
    private function getPostTypesTaxList()
    {
        $postTypesTaxList = [];

        $taxonomies = EntityManager::getTaxonomies();
        $postTypes  = array_keys( $this->getPostTypes() );

        foreach ( $postTypes as $postType ){
            foreach ( $taxonomies as $taxonomy) {

                if( in_array( $postType, $taxonomy->object_type ) ){
                    $postTypesTaxList[$postType][] = array(
                        'name'          => 'taxonomy_' . $taxonomy->name,
                        'hierarchical'  => $taxonomy->hierarchical
                    );
                }
            }
        }

        return $postTypesTaxList;
    }

    public function includeAdminJs()
    {
        $screen = get_current_screen();

        if( isset( $screen->id ) && $screen->id === FLRT_FILTERS_SET_POST_TYPE ){
            global $post_id;

            // Disable autosavings
            wp_dequeue_script( 'autosave' );

            $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
            $ver    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? rand(0, 1000) : FLRT_PLUGIN_VER;
            $select2ver = '4.1.0';

            // Filter Set script
            wp_enqueue_script('wpc-filters-admin-filter-set', FLRT_PLUGIN_URL . 'assets/js/wpc-filter-set-admin'.$suffix.'.js', array('jquery', 'wp-util', 'jquery-ui-sortable', 'select2'), $ver );

            $l10n = array(
                'filterSlugs'       => $this->getExistingFilterSlugs(),
                'postTypesTaxList'  => $this->getPostTypesTaxList(),
                'moreOptions'       => esc_html__( 'More options', 'filter-everything' ),
                'lessOptions'       => esc_html__( 'Less options', 'filter-everything' ),
                'filtersPro'        => defined( 'FLRT_FILTERS_PRO' ),
                'wPQuerySelectId'   => $this->generateFieldId('wp_filter_query'),
                'excludePlaceholder' => esc_html__('Select terms', 'filter-everything' ),
//                'enamePlaceHolder'   => esc_html__( '&mdash; Enter new or Select Meta Key &mdash;', 'filter-everything')
            );

            wp_localize_script( 'wpc-filters-admin-filter-set', 'wpcSetVars', $l10n );

            // Select2
            wp_enqueue_script( 'select2', FLRT_PLUGIN_URL . "assets/js/select2/select2".$suffix.".js", array('jquery'), $select2ver );
            wp_enqueue_style('select2', FLRT_PLUGIN_URL . "assets/css/select2/select2".$suffix.".css", '', $select2ver );

        }
    }

    public function addCustomLabel( $html, $attributes )
    {
        if( isset( $attributes['id'] ) ){
            if( $attributes['id'] == $this->generateFieldId('post_name') ){

                $spinner        = '<span class="spinner"></span>'."\r\n";
                $openContainer  = '<div id="wpc-field-location-container"><span class="wpc-full-width">&nbsp;</span>'."\r\n";
                $closeContainer = '</div>'."\r\n";
                $link           = '';

                $current_index = isset( $attributes['value'] ) ? $attributes['value'] : '';
                $options = ! empty( $attributes['options'] ) ? $attributes['options'] : [];

                if( isset( $options[ $current_index ]['data-link'] ) ){
                    $link = '<a class="wpc-location-preview" href="'.esc_attr( $options[ $current_index ]['data-link'] ).'" ';
                    $link .= 'title="'.esc_attr( esc_html__('Preview selected location in a new tab', 'filter-everything') ).'" ';
                    $link .= 'target="_blank">';
                    $link .= '<span class="dashicons dashicons-visibility"></span></a>';
                }
                $html = $spinner . $openContainer . $html . $link . $closeContainer;
            }

            if( $attributes['id'] == $this->generateFieldId('wp_filter_query') ){

                $spinner        = '<span class="spinner"></span>'."\n";
                $openContainer  = '<div id="wpc-field-wp-query-container">&nbsp;'."\n";
                $description    = '<p class="description">'.esc_html__( 'Note: if you will modify the query on the selected page, do not forget to update the current Filter Set.', 'filter-everything' ).'</p>'."\n";
                $closeContainer = '<div id="wpc_query_vars"></div></div>'."\n";

                $html = $spinner . $openContainer . $html . $description . $closeContainer;
            }

            if( $attributes['id'] == $this->generateFieldId('wp_page_type') ){
                $label          = '<label class="wpc-location-label" for="'.esc_attr($attributes['id']).'">'.esc_html__( 'Show this Filter Set if page is:', 'filter-everything' ).'</label>'."\r\n";
                $html =  $label . $html;
            }
        }

        return $html;
    }


    private function getSpecificFields( $type )
    {
        $particular = [];

        foreach( $this->getFieldsMapping() as $key => $field ){
            if( isset( $field[$type] ) && ! empty( $field[$type] ) ){
                $particular[ $key ] = $field;
            }
        }

        return $particular;
    }

    public function getPostTypes()
    {
        $allowed_types  = [];
        $post_types     = get_post_types( array( 'public' => true ), 'objects' );
        $exclude        = apply_filters( 'wpc_filter_post_types', [] );
       
        foreach ( $post_types as $type ){
            if( in_array( $type->name, $exclude ) ){
                continue;
            }
            $allowed_types[$type->name] = isset( $type->labels->name ) ? $type->labels->name : $type->labels->singular_name;
        }

        return $allowed_types;

    }

    public function getFieldsMapping()
    {
        return $this->defaultFields;
    }

    /**
     * @var $queriedObject object
     * @return array (empty array if there is no related set id)
    */
    public function findRelevantSets( $queriedObject )
    {
        // We need to search all relevantSetS
        $filterSet = [];

        $filterSet = apply_filters( 'wpc_relevant_set_ids', $filterSet, $queriedObject );

        if( ! empty( $filterSet ) ){
            return $filterSet;
        }

        // Get main filter set for post type
        if( isset( $queriedObject['post_types'] ) && ! isset( $queriedObject['post_id'] ) ){
            foreach( $queriedObject['post_types'] as $post_type ){
                $sets = $this->getSetIdForPostType( $post_type );
                if( $sets !== false ){
                    return $sets;
                }
            }
        }

        return $filterSet;
    }

    public function setIdForPostTypeWhere( $where, $wp_query )
    {
        global $wpdb;

        if( $wp_query->get('flrt_post_type') ){
            $post_type = $wp_query->get('flrt_post_type');
            $where = $where .' ' .$wpdb->prepare( " AND {$wpdb->posts}.post_excerpt = %s", $post_type );
        }

        return $where;
    }

    /**
     * @var $post_type string - post_type post|product|page|...
     * @return int|false
     */
    public function getSetIdForPostType( $post_type )
    {
        if( ! $post_type ){
            return false;
        }

        $container = Container::instance();
        $sets = [];

        $key = 'set_' . $post_type;

        if( ! $sets = $container->getParam( $key ) ){
            add_filter( 'posts_where', [$this, 'setIdForPostTypeWhere'], 10, 2 );
            // Set with higher menu_order or ID will be in top of results

            $args = array(
                'post_type'      => FLRT_FILTERS_SET_POST_TYPE,
                'post_status'    => 'publish',
                'post_name__in'  => array('1'),
                'orderby'        => array( 'menu_order' => 'DESC', 'ID' => 'ASC' ),
                'flrt_set_query' => true,
                'flrt_post_type' => $post_type,
//                'suppress_filters' => true
            );

            // Get only single Set in the free plugin version
            if( ! defined('FLRT_FILTERS_PRO') ){
                $args['posts_per_page'] = 1;
            }

            $setQuery = new \WP_Query();
            $setQuery->parse_query($args);

            $setPosts = $setQuery->get_posts();

            if( ! empty( $setPosts ) ){
                foreach ( $setPosts as $set ){

                    $sets[] = array(
                        'ID'                 => (string) $set->ID,
                        'filtered_post_type' => $set->post_excerpt,
                        'query'              => '-1'
                    );

                }
            }else{
                return false;
            }

            $container->storeParam( $key, $sets );

            remove_filter( 'posts_where', [$this, 'setIdForPostTypeWhere'], 10, 2 );
        }

        return $sets;
    }

    public function validateSets( $sets )
    {
        if( ! is_array( $sets ) || empty( $sets ) ){
            return false;
        }

        foreach ( $sets as $i => $set ){
            if( ! isset( $set['ID'] ) || ! $set['ID'] ){
                return false;
            }
        }

        return true;
    }

    public function preSaveSet( $post_id, $data )
    {
        $postData = Container::instance()->getThePost();

        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if( wp_is_post_revision( $post_id ) ) {
            return $post_id;
        }

        if( $data['post_type'] !== FLRT_FILTERS_SET_POST_TYPE ) {
            return $post_id;
        }

        $nonce = filter_input( INPUT_POST, '_flrt_nonce' );

        if( ! $this->verifyNonce( $nonce ) ) {
            return $post_id;
        }

        if( ! current_user_can( 'manage_options' ) ) {
            return $post_id;
        }

        // Do not fire this function twice, on saving Set Fields action
        remove_action( 'pre_post_update', [$this, 'preSaveSet'], 10 );

        $set_fields_key  = self::FIELD_NAME_PREFIX;

        if( isset( $postData[$set_fields_key] ) &&  ! empty( $postData[$set_fields_key] ) ){
            $setFields          = $postData[$set_fields_key];
            $setFields['ID']    = $post_id;
            $setFields['title'] = isset( $data['post_title'] ) ? $data['post_title'] : '';

            $setFields = apply_filters( 'wpc_pre_save_set_fields', $setFields );

            $setFields = $this->sanitizeSetFields( $setFields );

            if( ! $this->validateSetFields( $setFields ) ){
                flrt_redirect_to_error( $post_id, $this->errors );
            }
        }


        return $post_id;
    }

    public function saveSet( $post_id, $post )
    {
        $postData = Container::instance()->getThePost();
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if( wp_is_post_revision( $post_id ) ) {
            return $post_id;
        }

        if( $post->post_type !== FLRT_FILTERS_SET_POST_TYPE ) {
            return $post_id;
        }

        $nonce = filter_input( INPUT_POST, '_flrt_nonce' );

        if( ! $this->verifyNonce( $nonce ) ) {
            return $post_id;
        }

        if( ! current_user_can( 'manage_options' ) ) {
            return $post_id;
        }

        remove_action( 'save_post', array( $this, 'saveSet' ), 10, 2 );

        $filterFields = $this->getFilterFieldService();
        $saveFiltersTrigger = true;
        $allFiltersValid    = true;

        // Save filter fields
        if( isset( $postData['wpc_filter_fields'] ) && ! empty( $postData['wpc_filter_fields'] ) ) {

            // Validate filters
            if( ! $filterFields->validateFilters( $postData['wpc_filter_fields'] ) ) {
                $saveFiltersTrigger = false;
            }

            if( $saveFiltersTrigger ) {
                $filtersToSave = [];

                // loop
                $filterConfiguredFields = $filterFields->getFieldsMapping();
                foreach ($postData['wpc_filter_fields'] as $filterId => $filter) {

                    // Set up checkbox fields if they are empty
                    $filter = $filterFields->prepareFilterCheckboxFields($filter, $filterFields->getFieldsByType('checkbox', $filterConfiguredFields));

                    // set parent
                    if (!$filter['parent']) {
                        $filter['parent'] = $post_id;
                    }

                    $filter = $filterFields->sanitizeFilterFields($filter);
                    $filtersToSave[ $filterId ] = $filter;

                    if (!$filterFields->validateTheFilter($filter, $filterId)) {
                        $allFiltersValid = false;
                        break;
                    }

                }

                // Loop to save
                if( $allFiltersValid ){
                    foreach ( $filtersToSave as $filterId => $filter ){
                        // save filter
                        $filterFields->saveFilter($filter);
                    }
                }
            }
        }

        // Save Set fields
        $set_fields_key  = self::FIELD_NAME_PREFIX;

        if( isset( $postData[$set_fields_key] ) &&  ! empty( $postData[$set_fields_key] ) ){
            $setFields          = $postData[$set_fields_key];
            $setFields['ID']    = $post_id;
            $setFields['title'] = isset( $post->post_title ) ? $post->post_title : '';

            $this->saveSetFields( $setFields );
        }

        if( ! $saveFiltersTrigger || ! $allFiltersValid ){
            flrt_redirect_to_error( $post_id, $filterFields->getErrorCodes() );
        }

        add_action( 'save_post', array( $this, 'saveSet' ), 10, 2 );

        return $post_id;
    }



    private function saveSetFields( $setFields ){
        $post_id = $setFields['ID'];

        $setFields = apply_filters( 'wpc_pre_save_set_fields', $setFields );
        
        $setFields = $this->sanitizeSetFields( $setFields );

        $setFields = wp_unslash( $setFields );

        // Set up checkbox fields if they are empty
        $filterFields = $this->getFilterFieldService();
        /**
         * @feature It seems we need to move methods 'prepareFilterCheckboxFields' and 'getFieldsByType'
         * to one level above to parent class
         */
        $this->setupDefaultFields();
        $setFields = $filterFields->prepareFilterCheckboxFields( $setFields, $filterFields->getFieldsByType( 'checkbox', $this->getFieldsMapping()) );
        $_setFields = $setFields;

        // Remove elements, that shouldn't be serialized
        flrt_extract_vars( $_setFields, array( 'ID', 'title', 'post_type', 'menu_order', 'post_name', 'wp_filter_query_vars' ) );
        $menu_order = isset( $setFields['menu_order'] ) ? $setFields['menu_order'] : 0;

        // Create array of data to save.
        $to_save = array(
            'ID'			    => $setFields['ID'],
            'post_status'	    => 'publish',
            'post_type'		    => FLRT_FILTERS_SET_POST_TYPE,
            'post_title'	    => $setFields['title'],
            'post_content'	    => maybe_serialize( $_setFields ),
            'post_excerpt'      => $setFields['post_type'],
            'menu_order'        => $menu_order,
            'post_name'         => $setFields['post_name']
        );

        // Unhook wp_targeted_link_rel() filter from WP 5.1 corrupting serialized data.
        remove_filter( 'content_save_pre', 'wp_targeted_link_rel' );

        $to_save = wp_slash( $to_save );

        add_filter( 'pre_wp_unique_post_slug', 'flrt_force_non_unique_slug', 10, 2 );

        // Update or Insert.
        if( $setFields['ID'] ) {
            wp_update_post( $to_save );
        } else	{
            $setFields['ID'] = wp_insert_post( $to_save );
        }

        remove_filter( 'pre_wp_unique_post_slug', 'flrt_force_non_unique_slug', 10 );
        // Update meta_fields

        update_post_meta( $setFields['ID'], 'wpc_filter_set_post_type', $setFields['post_type'] );

        $set_query_vars = NULL;
        // Save selected wp_query->query_vars
        if( isset( $setFields['wp_filter_query'] ) ){
            $filterQueryHash = $setFields['wp_filter_query'];
            if( isset( $setFields['wp_filter_query_vars'][$filterQueryHash] ) ){
                $set_query_vars = $setFields['wp_filter_query_vars'][$filterQueryHash];
            }
        }

        update_post_meta( $setFields['ID'], 'wpc_filter_set_query_vars', $set_query_vars );

        return $setFields['ID'];
    }

    private function sanitizeSetFields( $setFields )
    {
        if( is_array( $setFields ) ){
            $sanitizedFields = [];

            foreach ( $setFields as $key => $setField ) {
                if( is_array( $setField ) ){
                    $sanitizedValue = $setField;
                }else{
                    $sanitizedValue = esc_html( $setField );
                }

                $sanitizedFields[ $key ] = $sanitizedValue;
            }

            if( isset( $sanitizedFields['menu_order'] ) ){
                $sanitizedFields['menu_order'] = flrt_sanitize_int( $sanitizedFields['menu_order'] );
                $sanitizedFields['menu_order'] = $sanitizedFields['menu_order'] ? $sanitizedFields['menu_order'] : 0;
            }

            return $sanitizedFields;
        }

        return $setFields;
    }

    private function prepareSetParameters( $set_post )
    {
        /**
         * @feature this should be not so complex. I'm ashamed of this.
         */
        if( ! isset( $set_post->ID ) ){
            return false;
        }

        $this->setupDefaultFields();
        $defaults = $this->getFieldsMapping();

        $defaults = apply_filters( 'wpc_prepare_filter_set_parameters', $defaults, $set_post );

        $unserialized = maybe_unserialize( $set_post->post_content );

        // For backward compatibility. From v.1.1.24
        if( isset( $unserialized['wp_page_type'] ) ){
            $unserialized['wp_page_type'] = str_replace(":", "___", $unserialized['wp_page_type']);
        }

        if( empty( $unserialized ) ){
            $unserialized = [];
        }

        foreach( $this->getSpecificFields( 'particular' ) as $key => $field ){
            $unserialized[$key] = $set_post->{$field['particular']};
        }

        $populated  = $this->populateValues( $unserialized, $defaults );
        $parsed     = $this->parseValues( $populated, $defaults );

        // In case if some settings field was missing
        $parsed = wp_parse_args( $parsed, $defaults );
        $parsed = apply_filters( 'wpc_filter_before_make_default_set_values', $parsed );

        // Set default values, if there is no saved
        foreach( $parsed as $field => $params ){

                if( isset( $params['particular'] ) && ! defined( 'FLRT_FILTERS_PRO' ) && $params['particular'] === 'post_name' ){
                    $parsed[$field]['value'] = $params['default'];
                }

                if( $field === 'wp_page_type' && ! defined( 'FLRT_FILTERS_PRO' ) ){
                    $parsed[$field]['value'] = $params['default'];
                }

                if( ! isset( $params['value'] ) && isset( $params['default'] )){
                    $parsed[$field]['value'] = $params['default'];
                }
        }

        return apply_filters( 'wpc_filter_set_prepared_values', $parsed );
    }

    private function parseValues( $populated, $defaults )
    {
        $parsed = [];

        foreach ( $populated as $field_key => $values_array ){
            // In case if we have saved field, that is absent in fieldsMapping
            if( ! isset( $defaults[$field_key] ) ){
                continue;
            }

            if( isset( $values_array['value'] ) ){
                $parsed[$field_key] = wp_parse_args( $values_array, $defaults[$field_key] );
            }else{
                $parsed[$field_key] = $this->parseValues( $values_array, $defaults[$field_key] );
            }
        }

        return $parsed;
    }

    private function populateValues( $saved_values )
    {
        $transformed = [];

        foreach ( $saved_values as $field_key => $field_value ) {
            if( is_array( $field_value ) ){
                $transformed[ $field_key ] = $this->populateValues( $field_value );
            }else{
                $transformed[ $field_key ] = array( 'value' => $field_value );
            }
        }

        return $transformed;
    }

    public function getSet( $ID )
    {
        $parameters = [];

        if( ! $ID || empty( $ID ) ){
            return $parameters;
        }

        $container = Container::instance();
        $key = 'wpc_set_' . $ID;

        if( ! $set = $container->getParam( $key ) ){
            $set_post = get_post( $ID );
            /**
             * @feature add this post to cache.
             */
            $set = $this->prepareSetParameters( $set_post );
            $container->storeParam( $key, $set );
        }

        return $set;
    }

    public function validateSetFields( $setFields ){

        // Validate post_type
        if( isset( $setFields['post_type'] ) ){
            $postTypes = array_keys( $this->getPostTypes() );
            if( ! in_array( $setFields['post_type'], $postTypes, true ) ){
                $this->errors[] = 21; // Invalid post type
                return false;
            }
        } else {
            $this->errors[] = 21; // Invalid post type
            return false;
        }

        // We have to validate wp_page_type before locations field
        // because the last one expects valid wp_page_type
        if( isset( $setFields['wp_page_type'] ) ){
            $possibleWpPageType = apply_filters( 'wpc_validation_wp_page_type_entities', array('common___common') );

            if( ! in_array( $setFields['wp_page_type'], $possibleWpPageType ) ){
                $this->errors[] = 211; // Invalid WP Page Type
                return false;
            }
        }else{
            $this->errors[] = 211; // Invalid WP Page Type
            return false;
        }

        // Validate post_name aka location
        // We can not forbid to save "No WP Queries..." option
        // Because All archive pages for selected post type may not contain relevant query.
        if( isset( $setFields['post_name'] ) ){
            $flatEntities   = apply_filters( 'wpc_validation_location_entities', array('1'), $setFields );

            if( ! in_array( $setFields['post_name'], $flatEntities ) ){
                $this->errors[] = 22; // Invalid location
                return false;
            }

        } else {
            $this->errors[] = 22; // Invalid location
            return false;
        }

        //Validate wp_filter_query
        if( isset( $setFields['wp_filter_query'] ) ){
            if(
                ! preg_match('/^[a-f0-9]{32}$/', $setFields['wp_filter_query'] )
                    &&
                $setFields['wp_filter_query'] !== '-1'
            ){
                $this->errors[] = 221; // Invalid WP Filter Query
                return false;
            }
        }else{
            $this->errors[] = 221; // Invalid WP Filter Query
            return false;
        }

        // Validate hide_empty
        if( isset( $setFields['hide_empty'] ) ){
            if( ! in_array( $setFields['hide_empty'], array( 'yes', 'no', 'initial' ), true ) ){
                $this->errors[] = 23; // Invalid empty field
                return false;
            }
        }

        // Validate show_count
        if( isset( $setFields['show_count'] ) ){
            if( ! in_array( $setFields['show_count'], array( 'yes', 'no' ), true ) ){
                $this->errors[] = 24; // Invalid show count
                return false;
            }
        }

        if( isset( $setFields['wp_filter_query_vars'] ) ){
            if( ! empty( $setFields['wp_filter_query_vars'] ) ){

                foreach ( $setFields['wp_filter_query_vars'] as $query_vars_serialized ){
                    if( ! is_serialized( $query_vars_serialized ) ){
                        $this->errors[] = 20; // Common Error
                        return false;
                    }
                }

            }
        }

        return $setFields;
    }

    private function getFilterFieldService()
    {
        return Container::instance()->getFilterFieldsService();
    }

    public function getPostTypeField( $post_id )
    {
        $set = $this->getSet( $post_id );
        $field['post_type'] = ( $set['post_type'] ) ? $set['post_type'] : NULL;
        return $field;
    }

    public function getSettingsTypeFields( $post_id )
    {
        $set = $this->getSet( $post_id );
        $settings_fields_map = $this->getSpecificFields('settings');

        return flrt_extract_vars($set, array_keys( $settings_fields_map ) );
    }

    public function generateFieldName( $field_name, $sub_name = '', $index = 0 ){
        $attr = self::FIELD_NAME_PREFIX . '['.$field_name.']';
        if( $sub_name ){
            $attr .= '['.$index.']['.$sub_name.']';
        }
        return $attr;
    }

    public function generateFieldId( $field_name, $sub_name = '', $index = 0 ){
        $attr = self::FIELD_NAME_PREFIX . '-' . $field_name;
        if( $sub_name ){
            $attr .= '-' . $sub_name . '-' . $index;
        }
        return $attr;
    }

    public static function createNonce()
    {
        return wp_create_nonce( self::NONCE_ACTION );
    }

    private function verifyNonce( $nonce )
    {
        return wp_verify_nonce( $nonce, self::NONCE_ACTION );
    }
}