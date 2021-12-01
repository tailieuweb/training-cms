<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class PostMetaNumEntity implements Entity
{
    public $items           = [];

    public $entityName      = '';

    public $excludedTerms   = [];

    public $new_meta_query  = [];

    public $postTypes       = [];

    public function __construct( $postMetaName, $postType ){
        /**
         * @feature clean code from unused methods
         */

        $this->entityName = $postMetaName;
        $this->setPostTypes( array($postType) );
    }

    public function setPostTypes( $postTypes = false )
    {
        $wpManager          = Container::instance()->getWpManager();
        $wpQueriedObject    = $wpManager->getQueryVar('wp_queried_object');

        if ($postTypes) {
            $this->postTypes = $postTypes;
        }elseif( ! empty( $wpQueriedObject['post_types'] ) ){
            $this->postTypes = $wpQueriedObject['post_types'];
        }else{
            $this->postTypes = array('post');
        }

        if( flrt_is_woocommerce()
            && in_array( 'product', $this->postTypes )
            && ! in_array( 'product_variation', $this->postTypes ) ){
            $this->postTypes[] = 'product_variation';
        }

        $this->getAllExistingTerms();
    }

    public static function inputName( $metaKey, $edge = 'min' )
    {
        if( mb_strpos( $metaKey, '_' ) === 0 ){
            return $edge . $metaKey;
        }

        return $edge . '_' . $metaKey;
    }

    public function setExcludedTerms( $excludedTerms )
    {
        $this->excludedTerms = $excludedTerms;
    }

    public function getName()
    {
        return $this->entityName;
    }

    function excludeTerms( $terms )
    {
        $exclude = [];

        if( ! empty( $this->excludedTerms ) ){
            $exclude = $this->excludedTerms;
        }

        foreach( $terms as $index => $term ){
            if( in_array( $term->slug, $exclude ) ){
                unset( $terms[$index] );
            }
        }

        return $terms;
    }

    function getTerms()
    {
        return  $this->excludeTerms( $this->getAllExistingTerms() );
    }

    /**
     * @param int $id term id
     * @return false|object term object of false
     */
    public function getTerm( $termId ){

        if( ! $termId ){
            return false;
        }

        foreach ( $this->getTerms() as $term ){
            if( $termId == $term->term_id ){
                return $term;
            }
        }

        return false;
    }

    public function getTermId( $slug )
    {
        /**
         * Post meta num value has no typical ID, so slug will be instead
         */
        return $slug . '_' . $this->getName();
    }

    /**
     * @return array list of term_id and names useful to create Select dropdown
     */
    public function getTermsForSelect()
    {
        $toSelect = [];
        foreach ( $this->getTerms() as $term ) {
            $toSelect[$term->slug] = $term->name;
        }

        return $toSelect;
    }

    public function getTermsForSelect2()
    {
        $toSelect = [];
        foreach ( $this->getTerms() as $term ) {
            $toSelect[] = array( 'id' => $term->slug, 'text' =>$term->name );
        }

        return $toSelect;
    }

    function getAllExistingTerms( $force = false )
    {
        if( empty( $this->items ) || $force ) {
            $this->items = $this->selectTerms();
        }

        return $this->items;
    }

    private function isDecimal( $step = 0, $value = 0 )
    {
        if( strpos( $step, '.') !== false ){
            return true;
        }

        if( strpos( $value, '.') !== false ){
            return true;
        }

        return false;
//        return is_numeric( $value ) && floor( $value ) != $value;
    }

    private function getTermPosts( $edge, $value )
    {   global $wpdb;
        $postIds    = [];
        $postTypes  = [];

        foreach ( $this->postTypes as $postType ){
            $pieces[] = $wpdb->prepare( "%s", $postType );
        }

        $IN = implode(", ", $pieces );

        $compare = '<=';
        if( $edge === 'min' ){
            $compare = '>=';
        }

        $type = $this->isDecimal( 0, $value) ? 'DECIMAL(15,6)' : 'SIGNED';

        $sql[] = "SELECT DISTINCT {$wpdb->postmeta}.post_id,{$wpdb->posts}.post_type";
        $sql[] = "FROM {$wpdb->postmeta}";
        $sql[] = "LEFT JOIN {$wpdb->posts} ON ({$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)";
        $sql[] = "WHERE {$wpdb->postmeta}.meta_key = %s";
        $sql[] = "AND CAST({$wpdb->postmeta}.meta_value AS {$type}) {$compare} %s";
        $sql[] = "AND {$wpdb->posts}.post_type IN( {$IN} )";

        $sql = implode(' ', $sql);

        $e_name     = wp_unslash( $this->entityName );
        $sql        = $wpdb->prepare( $sql, $e_name, $value );
        $result     = $wpdb->get_results( $sql, ARRAY_A );

        if( ! empty( $result ) ){
            foreach( $result as $post){
                $postIds[] = $post['post_id'];
                $postTypes[$post['post_id']] = $post['post_type'];
            }
        }

        return array( 'posts' => $postIds, 'post_types' => $postTypes);
    }

    function populateTermsWithPostIds( $setId, $post_type )
    {
        $wpManager          = Container::instance()->getWpManager();
        $queriedValues      = $wpManager->getQueryVar( 'queried_values' );

        if( $queriedValues ){
            foreach( $queriedValues as $slug => $filter ){
                if( $filter['e_name'] === $this->getName() ){
                    $values = $filter['values'];
                    break;
                }
            }

            foreach( $this->items as $index => $term ){
                if( isset( $values[$term->slug] ) ){
                    $term_posts = $this->getTermPosts( $term->slug, $values[$term->slug] );
                    $this->items[$index]->posts = $term_posts['posts']; // $this->getTermPosts( $term->slug, $values[$term->slug] );
                    $this->items[$index]->post_types = $term_posts['post_types'];
                }
            }
        }
    }

    public function selectTerms( $postsIn = [] ){

        $transient_key = flrt_get_terms_transient_key( $this->getName() );
        if ( false === ( $result = get_transient( $transient_key ) ) ) {
            global $wpdb;

            $IN = false;
            if( ! empty( $this->postTypes ) && isset($this->postTypes[0]) && $this->postTypes[0] ){
                foreach ( $this->postTypes as $postType ){
                    $pieces[] = $wpdb->prepare( "%s", $postType );
                }
                $IN = implode(", ", $pieces );
            }

            $sql[] = "SELECT {$wpdb->postmeta}.post_id,{$wpdb->postmeta}.meta_value";
            $sql[] = "FROM {$wpdb->postmeta}";
            $sql[] = "LEFT JOIN {$wpdb->posts} ON ({$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)";

            if( flrt_wpml_active() && defined( 'ICL_LANGUAGE_CODE' ) ){
                $sql[] = "LEFT JOIN {$wpdb->prefix}icl_translations AS wpml_translations";
                $sql[] = "ON {$wpdb->postmeta}.post_id = wpml_translations.element_id";

                if( ! empty( $this->postTypes ) ){

                    $sql[] = "AND wpml_translations.element_type IN(";

                    foreach( $this->postTypes as $type ){
                        $LANG_IN[] = $wpdb->prepare( "CONCAT('post_', '%s')", $type );
                    }
                    $sql[] = implode(",", $LANG_IN );

                    $sql[] = ")";

                }
            }

            $sql[] = "WHERE {$wpdb->postmeta}.meta_key = %s";

            if( $IN ){
                $sql[] = "AND {$wpdb->posts}.post_type IN( {$IN} )";
            }

            if( flrt_wpml_active() && defined( 'ICL_LANGUAGE_CODE' ) ){
                $sql[] = $wpdb->prepare("AND wpml_translations.language_code = '%s'", ICL_LANGUAGE_CODE);
            }

            $sql = implode(' ', $sql);

            $e_name     = wp_unslash( $this->entityName );
            $sql        = $wpdb->prepare( $sql, $e_name );

            $result     = $wpdb->get_results( $sql, ARRAY_A );

            set_transient( $transient_key, $result, FLRT_TRANSIENT_PERIOD_HOURS * HOUR_IN_SECONDS );
        }

        $new_result = [];
        $min_and_max = [
            'min' => 0,
            'max' => 0
        ];

        if( ! empty( $result ) ){
            if( ! empty( $postsIn ) ){
                foreach ( $result as $single_post ){
                    if( in_array( $single_post['post_id'], $postsIn ) ){
                        $new_result[ $single_post['post_id'] ] = $single_post['meta_value'];
                    }
                }
            }else{
                foreach ( $result as $single_post ){
                    $new_result[ $single_post['post_id'] ] = $single_post['meta_value'];
                }
            }
        }

        if( ! empty( $new_result ) ){
            $min_and_max = [
                'min' => floor( min( $new_result ) ),
                'max' => floor( max( $new_result ) )
            ];
        }

        return $this->convertSelectResult( $min_and_max );
    }

    public function updateMinAndMaxValues( $postsIn )
    {
        if( ! empty( $this->items ) && ! empty( $postsIn ) ){
            $newItems = $this->selectTerms( $postsIn );
            foreach ( $this->items as $index => $term ) {
                if( isset( $this->items[$index]->$index ) ){
                    $this->items[$index]->$index = $newItems[$index]->$index;
                }
            }
        }
    }

    private function createTermName( $edge, $value, $queried_values )
    {
        $name = $edge;
        $queriedFilter = false;

        if( $queried_values ){
            foreach ( $queried_values as $slug => $filter ){
                if( $filter['e_name'] === $this->getName() ){
                    $queriedFilter = $filter;
                    break;
                }
            }

            $name = $name .' '. $slug;
        }

        if( isset( $queriedFilter['values'][$edge] ) ) {
            $name = $name .' '. $queriedFilter['values'][$edge];
        }else{
            $name = $name .' '. $value;
        }

        return apply_filters( 'wpc_filter_post_meta_num_term_name', $name, $this->getName() );
    }

    private function convertSelectResult( $result ){
        $return = [];

        if( ! is_array( $result ) ){
            return $return;
        }

        // To make standard format for terms array;
        $i = 1;
        $wpManager      = Container::instance()->getWpManager();
        $queried_values = $wpManager->getQueryVar( 'queried_values' );

        foreach ( $result as $edge => $value ){

            $termObject = new \stdClass();
            $termObject->slug = $edge;
            $termObject->name = $this->createTermName( $edge, $value, $queried_values );
            $termObject->term_id = $edge . '_' . $this->getName();
            $termObject->posts = [];
            $termObject->count = 0;
            $termObject->cross_count = 0;
            $termObject->post_types = [];
            $termObject->$edge = $value;

            $return[ $edge ] = $termObject;

            $i++;
        }

        return $return;
    }

    private function isTermInMetaKey( $queried_value, $wp_query ){
        $duplicate  = [];
        $terms      = $queried_value['values'];
        $meta_key   = $wp_query->get('meta_key');
        $meta_value = $wp_query->get('meta_value');

        foreach ( $terms as $term ) {
            if( $queried_value['e_name'] === $meta_key ){
                if( $meta_value === $term ){
                    $duplicate['post_meta'] = $queried_value['e_name'];
                    $duplicate['term']      = $term;
                    return $duplicate;
                }
            }
        }

        return false;
    }

    private function isTermInMetaQuery( $queried_value, $wp_query ){
        $duplicate  = [];
        $meta_query = $wp_query->get('meta_query');
        $terms      = $queried_value['values'];

        if( ! empty( $meta_query ) ){

            foreach ( $meta_query as $query_array ){
                if( isset( $query_array['key'] ) && $query_array['key'] === $queried_value['e_name'] ){
                    if( isset( $query_array['value'] ) && in_array( $query_array['value'], $terms ) ){
                        $duplicate['post_meta'] = $queried_value['e_name'];
                        $duplicate['term']      = $query_array['value'];
                        return $duplicate;
                    }
                }
            }
        }

        return false;
    }

    public function isTermAlreadyInQuery( $queried_value, $wp_query )
    {
        // Is term in Key
        if( $duplicate = $this->isTermInMetaKey( $queried_value, $wp_query ) ){
            return $duplicate;
        }
        // Is term in Query
        if( $duplicate = $this->isTermInMetaQuery( $queried_value, $wp_query ) ){
            return $duplicate;
        }

        return false;
    }

    private function normalizeMetaQueryArray( $meta_query )
    {
        $normalized_meta_query = [];

        if( ! is_array( $meta_query ) || ! isset( $meta_query['key'] ) ){
            return false;
        }
        if( isset( $meta_query['value'] ) ){
            if( is_array( $meta_query['value'] ) ){
                sort( $meta_query['value'] );
                $meta_query['value'] = implode( '-', $meta_query['value'] );
                $normalized_meta_query['value']     = $meta_query['value'];
            }else{
                $normalized_meta_query['value'] = $meta_query['value'];
            }
        }

        $normalized_meta_query['key']       = $meta_query['key'];
        if( isset( $meta_query['compare'] ) ){
            $normalized_meta_query['compare']   = isset( $meta_query['compare'] ) ? $meta_query['compare'] : '';
        }

        return $normalized_meta_query;
    }

    private function isTheSameMetaQuery( $meta_query_1, $meta_query_2 )
    {
        $meta_query_1 = $this->normalizeMetaQueryArray($meta_query_1);
        $meta_query_2 = $this->normalizeMetaQueryArray($meta_query_2);

        $diff = array_diff( $meta_query_1, $meta_query_2 );

        if ( empty( $diff ) ){
            return true;
        }

        return false;
    }

    public function addMetaQueryArray( $meta_query_array, $relation = false )
    {
        if( ! isset( $meta_query_array['key'] ) ){
            return false;
        }

        $existing_meta_query = $this->new_meta_query;

        foreach ($existing_meta_query as $index => $present_query) {

            if ($this->hasNestedQueries($present_query)) {
                foreach ($present_query as $k => $nested_present_query) {

                    if (!isset($nested_present_query['key'])) {
                        // relation arg
                        continue;
                    }
                    if ($this->isTheSameMetaQuery($nested_present_query, $meta_query_array)) {
                        return false;
                    }
                }
            } else {
                if ($this->isTheSameMetaQuery($present_query, $meta_query_array)) {
                    return false;
                }
            }

        }

        if( $relation && in_array( $relation, array( 'AND', 'OR' ) ) ){
            $nested_index = $this->findNestedIndexForQuery($meta_query_array);
            $this->new_meta_query[$nested_index][] = $meta_query_array;
            $this->new_meta_query[$nested_index]['relation'] = $relation;
        }else{
            $this->new_meta_query[] = $meta_query_array;
        }

    }

    public function findNestedIndexForQuery( $meta_query_array )
    {
        $meta_key = $meta_query_array['key'];

        if( empty( $this->new_meta_query ) ){
            return 0;
        }

        foreach ( $this->new_meta_query as $i_level_1 => $maybe_meta_query ){
            // This subquery already exists
            if( isset( $maybe_meta_query[0]['key'] ) && $maybe_meta_query[0]['key'] === $meta_key ){
                return $i_level_1;
            }
        }

        return count( $this->new_meta_query );
    }

    public function hasNestedQueries( $meta_query )
    {
        if( isset( $meta_query[0]['key'] ) ){
            return true;
        }

        return false;
    }

    public function addMetaKeyToQuery( $wp_query )
    {
        $args = [];

        $args['key']   = $wp_query->get( 'meta_key' );
        if( $wp_query->get( 'meta_value'  ) ){
            $args['value'] = $wp_query->get( 'meta_value' );
            $args['compare'] = ( $compare = $wp_query->get( 'meta_compare' ) ) ? $compare : 'IN';
        }

        $wp_query->set( 'meta_key', '' );
        $wp_query->set( 'meta_value', '' );

        $this->addMetaQueryArray( $args );
    }

    public function importExistingMetaQuery( $wp_query )
    {
        // Try to check if there is meta_key, meta_value and meta_compare
        if( $wp_query->get('meta_key') ){
            $this->addMetaKeyToQuery( $wp_query );
        }

        $already_existing_meta_query = $wp_query->get('meta_query');

        if( is_array( $already_existing_meta_query ) ){
            foreach( $already_existing_meta_query as $value ){
                if( $this->hasNestedQueries( $value ) ){
                    foreach( $value as $n => $nested_meta_query ){
                        $this->addMetaQueryArray( $nested_meta_query, $value['relation'] );
                    }
                }else{
                    $this->addMetaQueryArray( $value );
                }

            }
        }
    }

    /**
     * @return object WP_Query
     */
    public function addTermsToWpQuery( $queried_value, $wp_query )
    {
        $meta_query = [];
        $key        = $queried_value['e_name'];
        // Add existing Meta Query if present
        $this->importExistingMetaQuery($wp_query);

        /**
         * @bug for Woo Products if we don't specify Max value it makes it 0.0000
         */
        $min = isset( $queried_value['values']['min'] ) ? $queried_value['values']['min'] : false;
        $max = isset( $queried_value['values']['max'] ) ? $queried_value['values']['max'] : false;

        // Compare with false because $min can be 0
        if( $min !== false ){
            $type = $this->isDecimal( $queried_value['step'], $min ) ? 'DECIMAL(15,6)' : 'NUMERIC';
            $meta_query = array(
                'key'     => $key,
                'value'   => $min,
                'compare' => '>=',
                'type'    => $type
            );
            $this->addMetaQueryArray( $meta_query );
        }

        if( $max !== false ){
            $type = $this->isDecimal( $queried_value['step'], $max ) ? 'DECIMAL(15,6)' : 'NUMERIC';
            $meta_query = array(
                'key'     => $key,
                'value'   => $max,
                'compare' => '<=',
                'type'    => $type
            );
            $this->addMetaQueryArray( $meta_query );
        }

        $this->addMetaQueryArray( $meta_query );


        if( count($this->new_meta_query) > 1 ){
            $this->new_meta_query['relation'] = 'AND';
        }

        $wp_query->set('meta_query', $this->new_meta_query );
        $this->new_meta_query = [];

        return $wp_query;
    }
}