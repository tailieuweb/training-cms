<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class PermalinksTab extends BaseSettings
{
    private $em;

    private $fs;

    protected $page = 'wpc-filter-admin-permalinks';

    protected $group = 'wpc_filter_permalinks';

    public $optionName = 'wpc_filter_permalinks';

    public function init()
    {
        add_action( 'admin_init', array( $this, 'initSettings') );
        add_filter( 'wpc_pre_save_filter', array( $this, 'maybeAddGlobalPrefix' ) );
        add_filter( 'wpc_after_get_filter', array( $this, 'prependGlobalPrefix' ) );

        add_action( 'after_delete_post', array( $this, 'maybeRemoveGlobalPrefix' ), 10, 2 );

        add_filter( 'pre_update_option', [$this, 'preUpdatePermalinks'], 10, 3 );

        add_action( 'wpc_after_settings_fields_title', array( $this, 'explanationMessage' ) );

        $this->em = Container::instance()->getEntityManager();
        $this->fs = Container::instance()->getFilterService();

    }

    public function initSettings()
    {
        $key_entities = [];

        $saved_options = get_option( $this->optionName );

        $flat_entities = $this->em->getFlatEntities();

        register_setting($this->group, $this->optionName);


        $settings = array(
            'wpc_slugs'      => array(
                'label'  => esc_html__( 'Global URL Var Names', 'filter-everything' ),
            )
        );

        if(defined('FLRT_FILTERS_PRO')){
            $settings = array(
                'wpc_slugs'      => array(
                    'label'  => esc_html__( 'Global filter prefixes and order', 'filter-everything' ),
                )
            );
        }


        if( ! $saved_options ){

            add_action('wpc_after_sections_settings_fields', array( $this, 'noFiltersMessage' ) );

        }else{
            /**
             * @bug When you draggin field its size is changing.
             */

            // Move post Meta Num values into end of the array
            $sorted_saved_options = $this->movePostMetaNumInTheEnd( $saved_options );

            foreach( $sorted_saved_options as $entity => $slug ){

                $entity_name = $this->fs->getEntityCanonicalName( $entity );

                $classes = array( 'regular-text' );

                if( defined('FLRT_FILTERS_PRO')  ){
                    $classes[] = 'pro-version';
                }else{
                    $classes[] = 'free-version';
                }

                if( $entity_name !== 'post_meta_num' ){
                    $classes[] = 'wpc-sortable-row';
                }

                $class = implode(' ', $classes);

                if( isset( $flat_entities[ $entity_name ] ) ) {

                    $translatable_title = defined('FLRT_FILTERS_PRO') ? sprintf( esc_html__( '%s prefix', 'filter-everything' ), $flat_entities[ $entity_name ] ) : sprintf( '%s', $flat_entities[ $entity_name ] );

                    $settings['wpc_slugs']['fields'][$entity] = array(
                        'type' => 'text',
                        'title' => $translatable_title,
                        'class' => $class,
                        'sortable' => true
                    );
                }
            }
        }

        $this->registerSettings($settings, $this->page, $this->optionName);
    }

    private function movePostMetaNumInTheEnd( $saved_options )
    {
        $post_meta_num_saved_options = [];
        $other_saved_options         = [];

        foreach( $saved_options as $entity => $slug ){
            if( mb_strpos( $entity, 'post_meta_num' ) !== false ){
                $post_meta_num_saved_options[$entity] = $slug;
            }else{
                $other_saved_options[$entity] = $slug;
            }
        }

        return array_merge( $other_saved_options, $post_meta_num_saved_options );
    }

    private function updatePostsPrefixes( $prefixChangeFrom, $prefixChangeTo )
    {
        $result = true;

        if( ! $prefixChangeFrom || ! $prefixChangeTo ){
            return false;
        }

        if( $prefixChangeFrom === $prefixChangeTo ){
            return false;
        }

        $args = array(
            'name' => $prefixChangeFrom,
            'post_type' => FLRT_FILTERS_POST_TYPE,
            'fields'    => 'ids',
            'posts_per_page' => -1
        );

        $filterPosts = new \WP_Query( $args );
        $postsToChange =  $filterPosts->get_posts();

        if( ! empty( $postsToChange ) ){
            foreach ( $postsToChange as $postId ){

                $toSave = array(
                    'ID' => $postId,
                    'post_name' => $prefixChangeTo
                );

                $toSave = wp_slash( $toSave );

                if( ! wp_update_post( $toSave ) && $result ){
                    $result = false;
                }
            }
        }

        return $result;
    }

    public function preUpdatePermalinks( $prefixesList, $option, $oldPrefixesList )
    {
        if( $option === $this->optionName ){
            if( is_array( $prefixesList ) && ! empty( $prefixesList ) ){
                $validator = new Validator();
                $sanitizedPrefixesList = [];

                foreach( $prefixesList as $entityKey => $prefix ){
                    $prefix = preg_replace( '/[^a-z0-9\-\_]+/', '', mb_strtolower($prefix) );
                    $prefix = trim($prefix, '-');

                    // Ensure, that prefix contains at least one alphabetic character
                    // Also this prevents from empty prefix
                    if( ! $validator->validateAlphabCharsExists( $prefix ) ){
                        add_settings_error( 'general', 'settings_updated', esc_html__( 'Prefix must contain at least one alphabetical character.', 'filter-everything' ), 'error' );
                        return $oldPrefixesList;
                    }

                    $sanitizedPrefixesList[ $entityKey ] = $prefix;
                }

                foreach( $sanitizedPrefixesList as $entityKey => $prefix ){
                    // Check hyphens problem when cat and cat-x exists
                    if( ! $validator->validatePrefixHyphens( $prefix, $sanitizedPrefixesList ) ){
                        add_settings_error( 'general', 'settings_updated', esc_html__( 'Prefix part before "-" character can not be equal with other existing prefix.', 'filter-everything' ), 'error' );
                        return $oldPrefixesList;
                    }

                    if( flrt_get_term_by_slug( $prefix ) ){
                        add_settings_error( 'general', 'settings_updated', sprintf( esc_html__( 'Prefix «%s» is not allowed, because such term already exists. Please, use another prefix.', 'filter-everything' ), $prefix ), 'error' );
                        return $oldPrefixesList;
                    }
                }

                if( ! $validator->validateDuplicates( $sanitizedPrefixesList ) ){
                    add_settings_error( 'general', 'settings_updated', esc_html__( 'Duplicate prefixes. Prefixes should be unique.', 'filter-everything' ), 'error' );
                    return $oldPrefixesList;
                }

                if( ! is_array( $oldPrefixesList ) ){
                    return $sanitizedPrefixesList;
                }

                // Update all filters with new prefix
                $prefixesChanged = array_diff( $sanitizedPrefixesList, $oldPrefixesList );

                foreach( $prefixesChanged as $entityKey => $prefix ){
                    if( isset( $oldPrefixesList[$entityKey] ) ){
                        $prefixChangeFrom = $oldPrefixesList[$entityKey];
                        $prefixChangeTo   = $sanitizedPrefixesList[$entityKey];
                        $this->updatePostsPrefixes( $prefixChangeFrom, $prefixChangeTo );
                    }
                }

                return $sanitizedPrefixesList;
            }
        }

        return $prefixesList;
    }

    // Add previously configured prefix to filter fields before show them
    public function prependGlobalPrefix( $filter )
    {
        $savedPrefixes = get_option( $this->optionName, [] );
        $entityKey     = $this->fs->getEntityKey( $filter['entity'], $filter['e_name'] );

        if( isset( $savedPrefixes[$entityKey] ) && $savedPrefixes[ $entityKey ] ){
            $filter['slug'] = $savedPrefixes[$entityKey];
        }

        return $filter;
    }

    public function maybeRemoveGlobalPrefix( $postId, $post )
    {
        if( $post->post_type !== FLRT_FILTERS_POST_TYPE ){
            return $postId;
        }
        $thePrefix = $post->post_name;

        $args = array(
            'post_type'         => FLRT_FILTERS_POST_TYPE,
            'posts_per_page'    => 1,
            'post_name__in'     => array( $thePrefix )
        );

        $exists = get_posts( $args );

        if( empty( $exists ) ){
            $savedPrefixes = get_option( $this->optionName, [] );

            foreach ( $savedPrefixes as $entityName => $prefix ){
                if( $thePrefix === $prefix ){
                    unset( $savedPrefixes[$entityName] );
                }
            }

            $this->updatePrefixes( $savedPrefixes );
        }

        return $postId;
    }

    public function maybeAddGlobalPrefix( $filter )
    {
        // Non-path segments we can store in separate settings
        // We need these slugs to have collection of them
        // But these entities shouldn't be available to change segments order.

        $savedPrefixes = get_option( $this->optionName, [] );
        $entityKey     = $this->fs->getEntityKey( $filter['entity'], $filter['e_name'] );

        // First Global prefix;
        if( ! $savedPrefixes || empty( $savedPrefixes ) ){
            $savedPrefixes = [];
            $savedPrefixes[ $entityKey ] = $filter['slug'];
            $this->updatePrefixes($savedPrefixes);
            return $filter;
        }

        if( isset( $savedPrefixes[ $entityKey ] ) && $savedPrefixes[ $entityKey ] ){
            // Force entity prefix to global before saving it.
            $filter['slug'] = $savedPrefixes[ $entityKey ];
        }else{
            $savedPrefixes[ $entityKey ] = $filter['slug'];
            $this->updatePrefixes( $savedPrefixes );
        }

        return $filter;
    }

    private function updatePrefixes( $prefixes )
    {
        /**
         * @feature Prefix may be deleted if form has old prefixes list and submitted.
        */

        return update_option( $this->optionName, $prefixes );
    }

    public function explanationMessage( $page )
    {
        if( $page === $this->page ){
            if( defined('FLRT_FILTERS_PRO') ){
                echo '<p>'.wp_kses( __( 'Edit, drag filter prefixes and arrange them in order you need.<br />This order determines filters order in URL.', 'filter-everything' ), array( 'br' => array() ) ).'</p>'."\r\n";
            }else{
                echo '<p>'.esc_html__( 'Edit var names.', 'filter-everything' ).'</p>'."\r\n";
            }
        }
    }

    function noFiltersMessage($page){
        if( $page === $this->page ){
            echo wp_kses(
                        sprintf( __('No filters have been created on this site yet. <a href="%s" target="_blank">Create your first one!</a>', 'filter-everything'), admin_url('post-new.php?post_type=' . FLRT_FILTERS_SET_POST_TYPE) ),
                        array( 'a' => array('href' => true, 'target' => true) )
            );
        }
    }

    public function getLabel()
    {
        return defined('FLRT_FILTERS_PRO') ? esc_html__('URL Prefixes', 'filter-everything') : esc_html__('URL Var Names', 'filter-everything');
    }

    public function getName()
    {
        return 'prefixes';
    }

    public function valid()
    {
        return true;
    }
}