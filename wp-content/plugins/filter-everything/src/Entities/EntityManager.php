<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

use FilterEverything\Filter\Pro\Entities\PostMetaExistsEntity;

class EntityManager
{
    const DEFAULT_PREFIX = 'filter-';

    public function __construct()
    {
        // Do nothing
    }

    public static function getTaxonomies()
    {
        $excludedTaxes = flrt_excluded_taxonomies();
        $args = [];
        $taxonomies = get_taxonomies($args, 'objects');

        foreach ($taxonomies as $t => $taxonomy) {
            if (in_array($taxonomy->name, $excludedTaxes)) {
                unset($taxonomies[$t]);
            }
        }

        return $taxonomies;
    }

    private function getData( $key )
    {
        return Container::instance()->getParam( $key );
    }

    private function storeData( $key, $data )
    {
        Container::instance()->storeParam( $key, $data );
    }

    /**
     * @param $key = $entity.'-'.$name
    */
    public function createEntity( $key, $postType = '' )
    {
        if( ! $key ){
            return false;
        }

        $fse   = Container::instance()->getFilterService();
        $name  = '';
        $parts = explode( $fse->sep, $key, 2 );

        $entity = $parts[0];
        $name   = $parts[1];

        $storeKey = $key;

        if( in_array( $entity, array( 'post_meta_num', 'post_meta_exists', 'post_meta', 'author' ) ) && $postType ){
            $storeKey = $key.'_'.$postType;
        }

        if( $entityExists = $this->getData( $storeKey ) ){
            return $entityExists;
        }

        switch( $entity ){
            case 'taxonomy':
                $this->storeData( $storeKey, new TaxonomyEntity( $name ) );
            break;

            case 'post_meta':
                $this->storeData( $storeKey, new PostMetaEntity( $name, $postType ) );
            break;

            case 'post_meta_num':
                $this->storeData( $storeKey, new PostMetaNumEntity( $name, $postType ) );
                break;

            case 'post_meta_exists':
                if( class_exists('FilterEverything\Filter\Pro\Entities\PostMetaExistsEntity') ) {
                    $this->storeData($storeKey, new PostMetaExistsEntity( $name, $postType ) );
                }else{
                    // For the plugin version downgrade compatibility
                    $this->storeData($storeKey, new DefaultEntity( $name ) );
                }
                break;

            case 'author':
                $this->storeData( $storeKey, new AuthorEntity( $name, $postType ) );
            break;
        }

        unset($fse, $parts, $entity, $name);

        return $this->getData( $storeKey );
    }

    public function getEntityByFilter( $filter, $postType = '' )
    {
        $fse = Container::instance()->getFilterService();

        if( ! isset( $filter['entity'] ) ){
            return false;
        }

        if( ! isset( $filter['e_name'] ) ){
            return false;
        }

        return $this->createEntity( $fse->getEntityKey( $filter['entity'], $filter['e_name'] ), $postType );

    }

    public function getPossibleTaxonomies()
    {
        $entities   = [];
        $args       = apply_filters( 'wpc_get_taxonomies_args', [] );
        $taxonomies = get_taxonomies( $args, 'objects' );
        $excluded_taxonomies = flrt_excluded_taxonomies();

        foreach ( $taxonomies as $taxonomy ){
            if( in_array( $taxonomy->name, $excluded_taxonomies ) ){
                continue;
            }
            // It is better to save value as 'taxonomy_pa_size' because
            // user potentially can create post_meta with the same name
            $label = ucwords( flrt_ucfirst( mb_strtolower( $taxonomy->label ) ) );
            $entities[ 'taxonomy_' . $taxonomy->name ] = $label;
        }

        return $entities;
    }

    public function getPossibleEntities()
    {
        $entities   = [];

        $entities['taxonomy']['group_label'] = esc_html__( 'Taxonomy Filters', 'filter-everything' );
        $entities['taxonomy']['entities'] = $this->getPossibleTaxonomies();

        $other = array(
            'post_meta'         => array(
                'group_label'   => esc_html__( 'Custom Field Filters', 'filter-everything' ),
                'entities'      => array(
                    'post_meta' =>  esc_html__( 'Custom Field', 'filter-everything' ),
                    'post_meta_num' => esc_html__( 'Custom Field Num', 'filter-everything' ),
                    'post_meta_exists' => esc_html__( 'Custom Field Exists - Available in Pro', 'filter-everything' ),
                )
            ),
            'other' => array(
                'group_label' => esc_html__( 'Other Filters', 'filter-everything' ),
                'entities' => array(
                    'author_author' => esc_html__( 'Post Author', 'filter-everything' )
                    )
            )
        );

        $result = array_merge( $entities, $other );

        $result = apply_filters( 'wpc_possible_entities', $result );

        return $result;
    }

    public function prepareFilterCommon( $entityAndEname, $filters = array() )
    {
        $filter = [];
        $e_name = '';
        $fs = Container::instance()->getFilterService();

        $allPermalinksSettings  = get_option( 'wpc_filter_permalinks' );
        $entityName = explode( $fs->sep, $entityAndEname, 2 );

        $filter['e_name'] = $e_name = $fs->getEntityEname( $entityAndEname );
        $filter['entity'] = $entityName[0];

        if( isset( $allPermalinksSettings[$entityAndEname] ) && $allPermalinksSettings[$entityAndEname] ){
            $filter['slug'] = $allPermalinksSettings[$entityAndEname];
            // This is messed up because label is not good index for this item, but it already exists
            // And I will try ty change it later. Maybe. Very very maybe :-)
            $filter['label'] = '{'.$allPermalinksSettings[$entityAndEname].'}';
        }

        if( isset( $filters[$e_name] ) ){
            $filter['title'] = $filters[$e_name]['label'];
        }

        return $filter;
    }

    public function getCommonFilterValues( $eName, $postType )
    {
        $filter = [];

        if( ! $eName || ! $postType ){
            return false;
        }

        $fs = Container::instance()->getFilterService();
        $allIndexedFilters  = get_option( 'wpc_seo_rules_settings' );

        foreach ( $allIndexedFilters as $item => $value ) {
            $itemKey = explode(":", $item, 2 );
            $maybePostType = $itemKey[0]; // post|product etc

            if( $maybePostType === $postType ){
                $entityAndEname = $itemKey[1];
                $entityName = explode( $fs->sep, $entityAndEname, 2 );

                if( $entityName[1] === $eName ){
                    $filter = $this->prepareFilterCommon( $itemKey[1] );
                    break;
                }
            }
        }

        return $filter;
    }

    public function getFilterBy( $by, $value, $onlyKeys = [], $setId = false )
    {
        $actualSets = [];
        $container = Container::instance();

        if( $setId ){
            $actualSets[0]['ID'] = $setId;
        }else{
            $wpManager = $container->getWpManager();
            $actualSets = $wpManager->getQueryVar( 'wpc_page_related_set_ids' );
        }

        if( empty( $actualSets ) || ! $actualSets ){
            return false;
        }

        $theFilter = [];

        foreach ( $actualSets as $actualSet ){

            $filterKey = 'filter_'.$by.'_'.$value.'_'.$actualSet['ID'];

            if( ! $theFilter = $container->getParam( $filterKey ) ){

                foreach( $this->getAllConfiguredFilters() as $filter ){

                    if( $filter[ $by ] === $value && $filter['parent'] === $actualSet['ID'] ){
                        $theFilter = $filter;
                        break;
                    }
                }

                $toStore = $theFilter ? $theFilter : 'empty';
                $container->storeParam( $filterKey, $toStore );

            }

            if( $theFilter !== 'empty' && ! empty( $theFilter ) ){
                break;
            }

        }

        if( $theFilter === 'empty' ){
            return array();
        }

        if( ! empty( $onlyKeys ) && ! empty( $theFilter ) ){
            return flrt_extract_vars( $theFilter, $onlyKeys );
        }

        return $theFilter;
    }

    /**
     * @param string $slug filters prefix e.g. 'cat', 'tag'
     * @param array $onlyKeys optional. Keys from filter array that should be extracted
     * @return array all matched filters from DB.
     */
    public function getAllFiltersBySlug( $slug, $onlyKeys = [] )
    {
        $theFilters = [];

        foreach( $this->getAllConfiguredFilters() as $filter ){
            if( $filter['slug'] === $slug ){
                $theFilters[] = $filter;
            }
        }

        if( ! empty( $onlyKeys ) ){
            $extractedFilters = [];
            foreach( $theFilters as $filter ){
                $extractedFilters[] = flrt_extract_vars( $filter, $onlyKeys );
            }
            return $extractedFilters;
        }

        return $theFilters;
    }

    public function getFilterBySlug( $slug, $onlyKeys = [] )
    {
        $theFilter = [];

        foreach( $this->getAllConfiguredFilters() as $filter ){
            if( $filter['slug'] === $slug ){
                $theFilter = $filter;
                break;
            }
        }

        if( ! empty( $onlyKeys ) ){
            return flrt_extract_vars( $theFilter, $onlyKeys );
        }

        return $theFilter;
    }

    public function getGlobalConfiguredSlugs()
    {
        $permalinksTab = new PermalinksTab();
        return get_option( $permalinksTab->optionName, [] );
    }

    public function getFlatEntities( $entities = false )
    {
        if( ! $entities ){
            $entities    = $this->getPossibleEntities();
        }

        $flat_entities = [];

        array_walk_recursive( $entities, function ( $value, $key ) use ( &$flat_entities ) {
            if( $key !== 'group_label' ){
                // $value = label
                $flat_entities[ $key ] = $value;
            }
        }, $flat_entities );

        return $flat_entities;
    }

    /**
     * @return array
    */
    public function extractBelongsFilters( $all_filters )
    {
        $result = [];
        if( ! is_array( $all_filters ) ){
            return $result;
        }

        $ffs = Container::instance()->getFilterFieldsService();

        foreach( $all_filters as $filter ) {
            if( $ffs->filterBelongsToPostType( $filter['parent'], $filter['entity'], $filter['e_name'] ) ){
                $result[] = $filter;
            }
        }

        return $result;
    }

    public function hasPostTypeFilters( $postType )
    {
        global $wpdb;

        $sql[] = "SELECT {$wpdb->posts}.ID FROM {$wpdb->posts}";
        $sql[] = "WHERE {$wpdb->posts}.post_type = '%s'";
        $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";
        $sql[] = "AND {$wpdb->posts}.post_excerpt = '%s'";
        $sql[] = "LIMIT 0, 1";

        $sql = implode(' ', $sql);

        $query      = $wpdb->prepare( $sql, FLRT_FILTERS_SET_POST_TYPE, $postType );
        $results    = $wpdb->get_results( $query, OBJECT );

        if( ! empty( $results ) ){
            return true;
        }

        return false;
    }

    public function getFiltersRelatedWithPostType( $postType, $entityName = '')
    {
        global $wpdb;

        $container  = Container::instance();

        // There shouldn't be duplicates in entities
        // Because of validation
        $sql[] = "SELECT {$wpdb->posts}.ID, {$wpdb->posts}.post_title, {$wpdb->posts}.post_content, {$wpdb->posts}.post_excerpt";
        $sql[] = "FROM {$wpdb->posts}";
        $sql[] = "WHERE {$wpdb->posts}.post_type = '%s'";
        $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";

        $sql[] = "AND {$wpdb->posts}.post_parent IN (";
        $sql[] = "SELECT {$wpdb->posts}.ID FROM {$wpdb->posts}";
        $sql[] = "WHERE {$wpdb->posts}.post_type = '%s'";
        $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";
        $sql[] = "AND {$wpdb->posts}.post_excerpt = '%s'"; // $postType
        $sql[] = ")";
        $sql[] = "ORDER BY {$wpdb->posts}.ID ASC";

        $sql = implode(' ', $sql);

        $query = $wpdb->prepare($sql, FLRT_FILTERS_POST_TYPE, FLRT_FILTERS_SET_POST_TYPE, $postType);

        $key        = $postType.'_get_related_filters';
        $results    = $container->getParam( $key );

        if( ! $results ){
            $results    = $wpdb->get_results( $query, OBJECT );
            if( ! $results ){
                $results = '-1';
            }
            $container->storeParam( $key, $results );
        }

        if( $results === '-1' ){
            return [];
        }

        $filters = [];
        foreach ( $results  as $result ) {
            $filterData = maybe_unserialize( $result->post_content );

            if( $entityName && mb_strpos( $result->post_excerpt, $entityName ) === false ){
                continue;
            }

            if( isset( $filters[ $filterData['e_name'] ] ) ){
                continue;
            }

            $filters[$filterData['e_name']]['ID'] = $result->ID;
            $filters[$filterData['e_name']]['label'] = $result->post_title;

            $filters[$filterData['e_name']] = array_merge( $filters[$filterData['e_name']], $filterData );
        }

        return $filters;
    }

    private function makeFiltersQuery()
    {
        $transient_key = 'wpc_filters_query';
        if ( false === ( $results = get_transient( $transient_key ) ) ) {
            global $wpdb;

            $sql[] = "SELECT {$wpdb->posts}.ID, {$wpdb->posts}.post_title, {$wpdb->posts}.post_content,";
            $sql[] = "{$wpdb->posts}.post_name, {$wpdb->posts}.post_parent, {$wpdb->posts}.menu_order";
            $sql[] = "FROM {$wpdb->posts}";
            $sql[] = "WHERE {$wpdb->posts}.post_type = '%s'";
            $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";
            $sql[] = "ORDER BY {$wpdb->posts}.menu_order ASC, {$wpdb->posts}.ID DESC";

            $sql = implode(' ', $sql);

            $query      = $wpdb->prepare( $sql, FLRT_FILTERS_POST_TYPE );
            $results    = $wpdb->get_results( $query, OBJECT );

            set_transient( $transient_key, $results, FLRT_TRANSIENT_PERIOD_HOURS * HOUR_IN_SECONDS );
        }

        if( ! $results ){
            return [];
        }

        return $results;
    }

    public function getAllConfiguredFilters()
    {
        $key = 'wpc_filters';

        if( ! $filters = $this->getData( $key ) ){
            $filters = [];

            foreach( $this->makeFiltersQuery() as $k => $filter_post ){
                $filter = $this->prepareFilter( $filter_post );
                    $filters[$k] = $filter;
            }

            $this->storeData( $key, $filters );
        }

        return $filters;
    }

    public function selectOnlySetFilters( $set_id, $keys = [] )
    {
        if( ! $set_id ){
            return false;
        }
        $setFilters = [];

        foreach( $this->getAllConfiguredFilters() as $filter ){
            if( $filter['parent'] == $set_id ){
                if( ! empty( $keys ) ){
                    $setFilters[] = flrt_extract_vars( $filter, $keys );
                }else{
                    $setFilters[] = $filter;
                }
            }
        }

        return $setFilters;
    }
    /**
     * @return array
    */
    public function getParamFromFilters( $filters, $key )
    {
        $result = [];
        if( ! is_array( $filters ) ){
            return $result;
        }

        foreach ( $filters as $_key => $_filter ){
            if( isset( $_filter[ $key ] ) ){
                $result[] = $_filter[ $key ];
            }
        }

        return $result;
    }

    public function getConfiguredPathSlugs( $filters = NULL )
    {
        $slugs = [];

        if( ! $filters ){
            $filters = $this->getAllConfiguredFilters();
        }

        foreach( $filters as $filter ){
            if( $filter['in_path'] === 'yes' ){
                $slugs[] = $filter['slug'];
            }
        }

        return $slugs;
    }

    public function getConfiguredQuerySlugs( $filters = NULL )
    {
        $slugs = [];

        if( ! $filters ){
            $filters = $this->getAllConfiguredFilters();
        }

        foreach( $filters as $filter ){

            if( FLRT_PERMALINKS_ENABLED ) {
                if ($filter['in_path'] === 'no') {
                    $slugs[] = $filter['slug'];
                }
            }else{
                $slugs[] = $filter['slug'];
            }
        }

        return $slugs;
    }

    public function prepareFilter( $filter_post )
    {
        if( ! isset( $filter_post->ID ) ){
            return false;
        }

        $raw_data       = (array) maybe_unserialize( $filter_post->post_content );
        $fse            = Container::instance()->getFilterService();
        $empty_filter   = $fse->getEmptyFilter();

        $defaults = array(
            'ID'         => $filter_post->ID,
            'parent'     => $filter_post->post_parent,
            'menu_order' => $filter_post->menu_order,
            'label'      => $filter_post->post_title,
            'slug'       => $filter_post->post_name
        );

        $filter = wp_parse_args( $raw_data, wp_parse_args( $defaults, $empty_filter ) );
        $filter = apply_filters( 'wpc_after_get_filter', $filter );

        unset($fse);

        return $filter;
    }

    /**
     * @param $sets
     * @return array
     */
    public function getOnlyBelongsFilters( $sets )
    {
        $relevantFilters = [];

        foreach ( $sets as $set ) {
            $relevantFilters[] = $this->selectOnlySetFilters( $set['ID'] );
        }

        $relevantFilters = flrt_remove_level_array($relevantFilters);
        return $this->extractBelongsFilters($relevantFilters);
    }

    public function checkForbiddenFilters( $queriedFilters, $allowedFilters )
    {
        $requestedSlugs = $this->getParamFromFilters( $queriedFilters, 'slug' );
        $allowedSlugs   = $this->getParamFromFilters( $allowedFilters, 'slug' );

        foreach( $requestedSlugs as $slug ){
            if( ! in_array( $slug, $allowedSlugs ) ){
                return false;
            }
        }

        return true;
    }

    public function getEntityAllTermsSlugs( $slug )
    {
        $slugs = [];
        $terms = $this->getEntityTermsBySlug( $slug );

        if( is_wp_error( $terms ) ){
            return $slugs;
        }

        foreach( $terms as $k => $termObject ){
            $slugs[ $termObject->term_id ] = $termObject->slug;
        }

        return $slugs;
    }

    /**
     * @param array $sets
     * @return array|false|mixed
     */
    public function getSetsRelatedFilters( $sets = [] )
    {
        /**
         * @todo we have to change this. Not page related, but Set related filters.
         */
        $subkey = '';
        $wpManager = Container::instance()->getWpManager();

        if( ! empty( $sets ) ){
            foreach ( $sets as $set ){
                $subkey .= '_' . $set['ID'];
            }
        }

        $key = 'wpc_related_filters'.$subkey;

        if ( ! $actual = Container::instance()->getParam( $key ) ) {

            if( empty( $sets ) ){
                $sets = $wpManager->getQueryVar( 'wpc_page_related_set_ids' );
            }

            $requested  = $wpManager->getQueryVar( 'queried_values', [] );

            $configured = $this->getOnlyBelongsFilters( $sets );
            $actual     = $configured;

            /**
             * @feature Create new method that populates filters with requested values
             * This should be there in EntityMananger because for all entities it should be done in the same way
             */
            foreach ( $configured as $k => $filter ) {
                // Merge with queried values
                $values = isset($requested[$filter['slug']]['values']) ? $requested[$filter['slug']]['values'] : [];
                $actual[$k]['values'] = $values;
            }

            Container::instance()->storeParam( $key, $actual );
        }

        return $actual;
    }

    /**
     * Should always return postIDs
     */
    public function getAlreadyFilteredPostIds( $setId, $exceptEntity = false )
    {
        /**
         * @bug searching of all queried post IDs doesn't work properly for two or more PostMetaNum filters in one set.
         */

        $wpManager              = Container::instance()->getWpManager();
        $allWpQueriedPostIds    = $this->getAllSetWpQueriedPostIds( $setId );

        $postIds                = $allWpQueriedPostIds ? $allWpQueriedPostIds : [];

        if( $wpManager->getQueryVar('wpc_is_filter_request') ){
            $filteredPostsIdsKeys        = $this->collectFilteredPostsIds( $setId );

            $allWpQueriedPostIdsKeys = array_flip( $allWpQueriedPostIds );
            $allWpQueriedPostIdsKeys = apply_filters( 'wpc_from_products_to_variations', $allWpQueriedPostIdsKeys );

            if( $exceptEntity ){
                unset($filteredPostsIdsKeys[$exceptEntity->getName()]);
            }

            if(! empty( $filteredPostsIdsKeys ) ) {
                $intersection_keys = $this->getBetweenFiltersIntersect($filteredPostsIdsKeys, $allWpQueriedPostIdsKeys);

                // Replace back from Variation IDs to Product IDs
                $postIds = apply_filters( 'wpc_from_variations_to_products', array_flip($intersection_keys) );
            }
        }

        return $postIds;
    }

    public function getAllSetWpQueriedPostIds( $setId )
    {
        $ids = [];
        if( ! $setId ){
            return $ids;
        }

        $wpManager = Container::instance()->getWpManager();
        $key = 'wpc_all_set_queried_post_ids_' . $setId;
        $ids = $wpManager->getQueryVar($key);

        if ( $ids === false ) {
            $set_filter_query = $wpManager->getQueryVar('wpc_set_filter_query_' . $setId);

            if( ! $set_filter_query ){
                $theGet         = Container::instance()->getTheGet();
                $savedQueryVars = get_post_meta( $setId, 'wpc_filter_set_query_vars', true );

                if( $savedQueryVars ){
                    $query_vars = maybe_unserialize( $savedQueryVars );

                    if( is_array( $query_vars ) ){
                        $set_filter_query = new \WP_Query();

                        if( isset( $theGet['s'] ) ){
                            $query_vars['s'] = $theGet['s'];
                        }

                        $set_filter_query->query_vars = $query_vars;
                    }
                }
            }

            if ($set_filter_query instanceof \WP_Query) {

                // Configure WP_Query object to select only posts IDs
                $set_filter_query->set('fields', 'ids');
                $set_filter_query->set('posts_per_page', -1);
                $set_filter_query->set('nopaging', true);
                $set_filter_query->set('post_status', 'publish');
                $set_filter_query->set('flrt_query_clone', true);

                $ids = $set_filter_query->get_posts();

            }

            $ids = (! empty( $ids ) ) ? $ids : [];

            $wpManager->setQueryVar($key, $ids);

            unset($set_filter_query);
        }

        return $ids;
    }

    // This method must be executed before output
    public function prepareEntitiesToDisplay( $sets )
    {
        $container = Container::instance();
        $wpManager = $container->getWpManager();
        $subkey = '';

        $post_type      = $sets[0]['filtered_post_type'];
        $setId          = $sets[0]['ID'];

        $all_sets = $wpManager->getQueryVar('wpc_page_related_set_ids');
        $queryRelatedSets = flrt_get_sets_with_the_same_query( $all_sets, $setId );

        $relatedSets = [];
        foreach ( $queryRelatedSets as $set_id ){
            $relatedSets[] = array( 'ID' => $set_id );
        }

        $subkey = implode( '_', $queryRelatedSets );

        $key = 'wpc_entities_prepared_' . $subkey;

        if( ! $container->getParam( $key ) ) {

            $relatedFilters = $this->getSetsRelatedFilters( $relatedSets );
            $allPostsIds    = $this->getAllSetWpQueriedPostIds( $setId );

            if (!empty($allPostsIds)) {
                $allPostsIds = array_flip($allPostsIds);
            }

            $allEntities = [];

            if (!empty($relatedFilters)) {

                foreach ($relatedFilters as $filter) {

                    // Part 1 collect all entities
                    $entity = $this->getEntityByFilter($filter, $post_type);

                    if ($entity instanceof PostMetaExistsEntity) {
                        $entity->setPostTypes( array( $post_type ) );
                    }

                    $entity->populateTermsWithPostIds( $setId, $post_type );

                    $allEntities[$entity->getName()] = $entity;
                }

            }

            // Post IDs with variations instead of parent products
            $filteredAllPostsIds = $this->collectFilteredPostsIds( $setId );
            $allPostsIds         = apply_filters( 'wpc_from_products_to_variations', $allPostsIds );

            foreach ($allEntities as $entityName => $entity) {

                $filter = $this->getFilterBy('e_name', $entityName, array('logic', 'e_name', 'orderby', 'used_for_variations'));

                foreach ($entity->items as $index => $term) {
                    $entity->items[$index]->count = count($entity->items[$index]->posts);
                }

                if ($entity instanceof PostMetaNumEntity) {
                    $postsIn = apply_filters( 'wpc_min_and_max_values_post_meta_num', $this->getAlreadyFilteredPostIds( $setId, $entity ), $entity );
                    $entity->updateMinAndMaxValues($postsIn);
                }

                if( in_array( $filter['orderby'], ['menuasc', 'menudesc'] ) ){
                    if( $entity instanceof TaxonomyEntity ){
                        foreach ($entity->items as $k => $term) {
                            $termOrder = get_term_meta($term->term_id, 'order', true);
                            $term->menu_order   = $termOrder ? $termOrder : 0;
                            $entity->items[$k]  = $term;
                        }
                    }
                }

                $entity->items = $this->sortTerms($entity->items, $filter['orderby']);

                /**
                 * @feature move selected terms to top
                 */
                $used_for_variations = isset( $filter['used_for_variations'] ) ? $filter['used_for_variations'] : false;
                $entity->items = apply_filters( 'wpc_items_before_calc_term_count', $entity->items, $entity, $used_for_variations );

                foreach ($entity->items as $index => $term) {
                    $entity->items[$index]->cross_count = $this->calcTermCount(array_flip($term->posts), $filteredAllPostsIds, $allPostsIds, $filter );
                }

//                $entity->items = apply_filters( 'wpc_items_after_calc_term_count', $entity->items );


            }

            $container->storeParam( $key, true );
        }
    }

    /**
     * @param array $terms list of terms
     * @param string $sortby
     * @return array sorted list of terms
     */
    private function sortTerms( $terms, $sortby )
    {
        if( ! $sortby ){
            $sortby = 'nameasc';
        }

        switch( $sortby ){
            case 'nameasc':
                usort( $terms, self::compareAsc('name') );
                break;
            case 'postcountasc':
                usort( $terms, self::compareAsc('count') );
                break;
            case 'idasc':
                usort( $terms, self::compareAsc('term_id') );
                break;
            case 'menuasc':
                usort( $terms, self::compareAsc('menu_order') );
                break;
            case 'namedesc':
                usort( $terms, self::compareDesc('name') );
                break;
            case 'postcountdesc':
                usort( $terms, self::compareDesc('count') );
                break;
            case 'iddesc':
                usort( $terms, self::compareDesc('term_id') );
                break;
//            case 'crosscount':
//                usort( $terms, self::compareAsc('cross_count') );
//                break;
            case 'menudesc':
                usort( $terms, self::compareDesc('menu_order') );
                break;
        }

        return $terms;
    }

    public static function compareAsc( $key ){

        return function ($a, $b) use ($key) {
            $value_1 = isset( $a->$key ) ? strtolower($a->$key) : 0;
            $value_2 = isset( $b->$key ) ? strtolower($b->$key) : 0;

            if ($value_1 == $value_2) {
                return 0;
            }

            return ($value_1 > $value_2) ? +1 : -1;
        };
    }

    public static function compareDesc( $key ){
        return function ($a, $b) use ($key) {
            $value_1 = isset( $a->$key ) ? strtolower($a->$key) : 0;
            $value_2 = isset( $b->$key ) ? strtolower($b->$key) : 0;

            if ($value_1 == $value_2) {
                return 0;
            }

            return ($value_1 < $value_2) ? +1 : -1;
        };
    }

    public function calcTermCount( $termPostsIds, $filteredPostsIds, $allPostsIds, $filter )
    {
        if( empty( $termPostsIds ) ){
            return 0;
        }

        $e_name = $filter['e_name'];
        $logic  = $filter['logic'];

        if( ! isset( $filteredPostsIds[$e_name] ) ){
            $filteredPostsIds[$e_name] = [];
        }

        // Intersection for logic OR between filter terms
        if ( $logic === 'or' ) {

            $filteredPostsIds[$e_name] += $termPostsIds;

        // Intersection for logic AND between filter terms
        } elseif ( $logic === 'and' ) {

            if( ! empty( $filteredPostsIds[$e_name] ) ){
                $filteredPostsIds[$e_name] = array_intersect_key( $allPostsIds, $filteredPostsIds[$e_name], $termPostsIds );
            }else{
                $filteredPostsIds[$e_name] = array_intersect_key( $allPostsIds, $termPostsIds );
            }

        }

        $betweenFiltersIntersect = $this->getBetweenFiltersIntersect( $filteredPostsIds, $allPostsIds );
        $finalInterSection = apply_filters( 'wpc_from_variations_to_products', array_flip( array_intersect_key( $betweenFiltersIntersect, $termPostsIds ) ) );

        return count( $finalInterSection );
    }

    public function getBetweenFiltersIntersect( $filteredPostsIds, $allPostsIds )
    {
        $betweenFiltersAND = [];
        /**
         * @bug when intersection is already empty, this count another intersection as more than 0
         * example - http://filter.stepasyuk.com/shop/category-hoodies/color-red/alphabet-alpha/
         * when there are hidden product, counter also doesn't work properly
         * example - http://filter.stepasyuk.com/shop/category-music/
         */

        // This implements logic AND between separate filters
        if ( ! empty( $filteredPostsIds ) ) {
            $i = 1;
            foreach ( $filteredPostsIds as $e_name => $singleFilterPostsIds ) {
                if( $i !== 1 ) {
                    $betweenFiltersAND = array_intersect_key( $allPostsIds, $betweenFiltersAND, $singleFilterPostsIds );
                } else {
                    $betweenFiltersAND = array_intersect_key( $allPostsIds, $singleFilterPostsIds );
                }
                $i++;
            }
        }

        // Final intersect between All posts and Filtered
        return array_intersect_key( $allPostsIds, $betweenFiltersAND );
    }

    public function getTaxonomyTermsForDropdown( $taxonomyName, $optionGroup = false )
    {
        $terms = [];
        if( ! $taxonomyName ){
            return $terms;
        }

        $filter['e_name'] = $taxonomyName;
        $filter['entity'] = 'taxonomy';
        $entity = $this->getEntityByFilter( $filter );

        if( ! $entity ){
            return $terms;
        }

        return $entity->getTermsForSelect( $optionGroup );
    }

    public function getAuthorTermsForDropdown( $optionGroup = false )
    {
        $args = array(
            'has_published_posts' => true,
            'orderby'             => 'display_name'
        );

        $key = 'wpc_users';
        if( $optionGroup ){
            $key .= '_group';
        }

        if( ! $authors = $this->getData( $key ) ) {
            $users = get_users($args);

            foreach ($users as $user) {
                if ($optionGroup) {
                    $authors["author:" . $user->ID] = $user->data->display_name;
                } else {
                    $authors[$user->ID] = $user->data->display_name;
                }
            }

            $this->storeData( $key, $authors );
        }

        return $authors;
    }

    public function safeExplodeFilterValues( $params, $slug, $sep, $explode = true )
    {
        $allEntityTerms = $this->getEntityAllTermsSlugs( $slug );

        foreach( $allEntityTerms as $entityTerm ){
            // Detect separator in term
            if( mb_strpos( $entityTerm, $sep ) !== false ){
                $position = strrpos( $params, $entityTerm );

                if ( $position !== false ) {
                    $replacement = str_replace( $sep, '#', $entityTerm );
                    $params = substr_replace( $params, $replacement, $position, mb_strlen( $entityTerm ) );
                }
            }
        }

        if( $explode ){
            return explode( $sep, $params );
        }

        return $params;
    }

    public function safeImplodeFilterValues( $filterValues, $sep )
    {
        if( ! is_array( $filterValues ) ){
            return [];
        }
        // Replace back
        array_walk($filterValues, function (&$value) use ($sep) {
            $value = str_replace('#', $sep, $value);
        });

        return $filterValues;
    }

    /**
     * @return array List of all queried posts or empty array
     */
    public function collectFilteredPostsIds( $setId )
    {
        $wpManager      = Container::instance()->getWpManager();
        $fss            = Container::instance()->getFilterSetService();

        $theSet         = $fss->getSet( $setId );
        $postType       = isset( $theSet['post_type']['value'] ) ? $theSet['post_type']['value'] : '';
        $allSetPostsIds = $this->getAllSetWpQueriedPostIds( $setId );
        $queriedFilters = $wpManager->getQueryVar('queried_values');

        if( $allSetPostsIds ){
            $allSetPostsIds = array_flip( $allSetPostsIds );
        }

        $allSetPostsIds = apply_filters( 'wpc_from_products_to_variations', $allSetPostsIds );

        if( ! $wpManager->getQueryVar('wpc_is_filter_request') ){
            return [];
        }

        $queriedAllPosts = [];

        $all_sets = $wpManager->getQueryVar('wpc_page_related_set_ids');
        $queryRelatedSets = flrt_get_sets_with_the_same_query( $all_sets, $setId );

        $set_filter_keys = $this->getSetFilterKeys( $queryRelatedSets );

        foreach( $queriedFilters as $slug => $queriedFilter ){

            $queried_value_key = $queriedFilter['entity'].'#'.$queriedFilter['e_name'];
            if( ! in_array( $queried_value_key, $set_filter_keys ) ){
                continue;
            }

            $entity = $this->getEntityByFilter( $queriedFilter, $postType );

            $e_name = $queriedFilter['e_name'];
            $queriedAllPosts[$e_name] = [];

            // Allows to replace product IDs with their variation IDs
            $entity->items = apply_filters( 'wpc_items_before_calc_term_count', $entity->items, $entity, $queriedFilter['used_for_variations'] );
            foreach( $entity->items as $term ){

                if( ! isset( $term->posts ) ){
                    continue;
                }

                if( $queriedFilter['entity'] === 'post_meta_num' ){
                    $doCalculate = in_array( $term->slug, array_keys( $queriedFilter['values'] ) );
                }else{
                    $doCalculate = in_array( $term->slug, $queriedFilter['values'] );
                }

                if ( $doCalculate ) {

                    // Intersection for logic OR between filter terms
                    if ( $queriedFilter['logic'] === 'or' ) {

                        $queriedAllPosts[$e_name] += array_flip($term->posts);

                    // Intersection for logic AND between filter terms
                    } elseif ( $queriedFilter['logic'] === 'and' ) {

                        if( ! empty( $queriedAllPosts[$e_name] ) ){
                            $queriedAllPosts[$e_name] = array_intersect_key( $allSetPostsIds, $queriedAllPosts[$e_name], array_flip($term->posts) );
                        } else {
                            $queriedAllPosts[$e_name] = array_intersect_key( $allSetPostsIds, array_flip($term->posts) );
                        }
                    }
                }
            }
            // Replace back from variation IDs to their product IDs
//            $entity->items = apply_filters( 'wpc_items_after_calc_term_count', $entity->items );
        }

        return $queriedAllPosts;
    }

    public function getSetFilterKeys( $setIds )
    {
        $set_filter_keys = [];

        if( ! $setIds || empty( $setIds )){
            return $set_filter_keys;
        }

        $sets = [];
        foreach( $setIds as $setId ){
            $sets[] = array( 'ID' => $setId );
        }

        $set_filters     = $this->getSetsRelatedFilters( $sets );

        foreach ( $set_filters as $filter ){
            $set_filter_keys[] = $filter['entity'].'#'.$filter['e_name'];
        }

        return $set_filter_keys;
    }

    public function getEntityTermsBySlug( $slug )
    {
        // Slug is not unique param, but it's ok for this case.
        $filterEntity   = $this->getFilterBySlug( $slug , array( 'entity', 'e_name' ) );
        $entity         = $this->getEntityByFilter( $filterEntity );

        return $entity->getAllExistingTerms();
    }

    public function addTermsToWpQuery( $queried_value, $wp_query )
    {
        $entity = $this->getEntityByFilter( $queried_value );
        return $entity->addTermsToWpQuery( $queried_value, $wp_query );
    }

}