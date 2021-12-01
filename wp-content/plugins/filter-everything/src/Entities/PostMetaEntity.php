<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class PostMetaEntity implements Entity
{
    public $items = [];

    public $entityName = '';

    public $excludedTerms = [];

    private $new_meta_query = [];

    /**
     * @todo We need to set parameter PosType to select only that post meta terms, that
     * belongs to this post type. Otherwise we will have many extra terms. !!! IMPORTANT
     */
    private $postTypes = [];

    public function __construct( $postMetaName, $postType ){
        $this->entityName = $postMetaName;

        if( $postType ){
            $this->setPostTypes( array( $postType ) );
        }

        $this->getAllExistingTerms();
    }

    public function setPostTypes( $postTypes )
    {
        $this->postTypes = $postTypes;

        if( flrt_is_woocommerce()
            && in_array( 'product', $this->postTypes )
            && ! in_array( 'product_variation', $this->postTypes ) ){
            $this->postTypes[] = 'product_variation';
        }

    }

    public function setExcludedTerms( $excludedTerms )
    {
        $this->excludedTerms = $excludedTerms;
    }

    public function getName()
    {
        return wp_unslash( $this->entityName );
    }

    public function getPostTypes()
    {
        return $this->postTypes;
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
    public function getTerm( $slug ){
        if( ! $slug ){
            return false;
        }

        foreach ( $this->getTerms() as $term ){
            if( $slug == $term->slug ){
                return $term;
            }
        }

        return false;
    }

    public function getTermId( $slug )
    {
        /**
         * Post meta value has no ID, so slug will be instead
         */
        return $slug;
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

    function populateTermsWithPostIds( $setId, $post_type )
    {
        // Correct term posts if they were selected without specified postTypes
        foreach( $this->items as $index => $term ){
            foreach( $term->post_types as $post_id => $term_post_type ){
                if( ! in_array($term_post_type, $this->postTypes ) ){
                    $position = array_search( $post_id, $term->posts );
                    unset( $this->items[$index]->posts[$position] );
                }
            }
        }
    }

    private function selectTerms(){
        global $wpdb;

        $e_name = wp_unslash( $this->entityName );
        $transient_key = flrt_get_terms_transient_key( $e_name );

        if ( false === ( $result = get_transient( $transient_key ) ) ) {

            $sql[] = "SELECT {$wpdb->postmeta}.post_id,{$wpdb->postmeta}.meta_value,{$wpdb->posts}.post_type";
            $sql[] = "FROM {$wpdb->postmeta}";
            $sql[] = "LEFT JOIN {$wpdb->posts} ON ({$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)";

            /**
             * @todo make it through apply_filter();
             */
            if (flrt_wpml_active() && defined('ICL_LANGUAGE_CODE')) {
                $sql[] = "LEFT JOIN {$wpdb->prefix}icl_translations AS wpml_translations";
                $sql[] = "ON {$wpdb->postmeta}.post_id = wpml_translations.element_id";

                if (!empty($this->postTypes)) {
                    $sql[] = "AND wpml_translations.element_type IN(";
                    foreach ($this->postTypes as $type) {
                        $LANG_IN[] = $wpdb->prepare("CONCAT('post_', '%s')", $type);
                    }
                    $sql[] = implode(",", $LANG_IN);
                    $sql[] = ")";
                }
            }

            $sql[] = "WHERE {$wpdb->postmeta}.meta_key = %s";

            if (!empty($this->postTypes)) {
                $sql[] = "AND {$wpdb->posts}.post_type IN(";
                foreach ($this->postTypes as $type) {
                    $IN[] = $wpdb->prepare("%s", $type);
                }
                $sql[] = implode(",", $IN);
                $sql[] = ")";
            }

            /**
             * @todo make it through apply_filter();
             */
            if (flrt_wpml_active() && defined('ICL_LANGUAGE_CODE')) {
                $sql[] = $wpdb->prepare("AND wpml_translations.language_code = '%s'", ICL_LANGUAGE_CODE);
            }

            $sql[] = "ORDER BY {$wpdb->postmeta}.meta_id ASC";
            /**
             * @notice It would be great to make LEFT JOIN posts where post type is post type from the filter SET
             * But it seems we can't know post type on this stage of WP loading (in RequestParser).
             */

            $sql = implode(' ', $sql);

            $sql = $wpdb->prepare($sql, $e_name);
            $result = $wpdb->get_results($sql, ARRAY_A);

            set_transient( $transient_key, $result, FLRT_TRANSIENT_PERIOD_HOURS * HOUR_IN_SECONDS );
        }


        return $this->convertSelectResult( $result );
    }

    private function hasRestrictedSymbols( $str )
    {
        if( $str !== esc_attr( $str ) ){
            return true;
        }

        if( preg_match( '/[#]+/', $str ) ){
            return true;
        }

        return false;
    }

    private function convertSelectResult( $result ){
        $return = [];

        if( ! is_array( $result ) ){
            return $return;
        }
        $customIndex = 1;
        // To make standard format for terms array;
        foreach ( $result as $index => $post_meta_row ){

            if( is_serialized( $post_meta_row['meta_value'] ) ){
                $data = maybe_unserialize( $post_meta_row['meta_value'] );
                foreach ( $data as $i => $meta_value ){
                    // For multidimensional arrays stored in post meta
                    if( is_array($meta_value) ){
                        continue;
                    }
                    $customIndex++;
                    $slug = sanitize_title($meta_value); //strtolower( $value );
                    if( $this->hasRestrictedSymbols( $slug ) ){
                        continue;
                    }
                    $this->addNewTerm( $return, $slug, $post_meta_row, $meta_value, $customIndex );
                }
            }else{

                $customIndex++;
                $slug = sanitize_title( $post_meta_row['meta_value'] );
                if( $this->hasRestrictedSymbols( $slug ) ){
                    continue;
                }
                $this->addNewTerm( $return, $slug, $post_meta_row, $post_meta_row['meta_value'], $customIndex );
            }

        }

        return $return;
    }

    private function addNewTerm( &$return, $slug, $post_meta_row, $meta_value, $index )
    {
        if( isset( $return[ $slug ] ) ){
            $return[ $slug ]->posts[] = $post_meta_row['post_id'];
            $return[ $slug ]->count++;
            $return[ $slug ]->post_types[$post_meta_row['post_id']] = $post_meta_row['post_type'];
        }else{
            $termObject = new \stdClass();
            $termObject->slug = $slug;
            $termObject->meta_value = $meta_value;
            $termObject->name = apply_filters( 'wpc_filter_post_meta_term_name', $meta_value, $this->getName() );
            $termObject->term_id = ($index + 1); // To avoid term_id = 0
            $termObject->posts = array( $post_meta_row['post_id'] );
            $termObject->count = 1;
            $termObject->cross_count = 0;
            $termObject->post_types[$post_meta_row['post_id']] = $post_meta_row['post_type'];

            $return[ $slug ] = $termObject;
        }
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

    public function isTermAlreadyInQuery( $queried_value, $wp_query ){
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

    private function isTheSameMetaQuery( $meta_query_1, $meta_query_2 ){
        $meta_query_1 = $this->normalizeMetaQueryArray($meta_query_1);
        $meta_query_2 = $this->normalizeMetaQueryArray($meta_query_2);

        $diff = array_diff( $meta_query_1, $meta_query_2 );

        if ( empty( $diff ) ){
            return true;
        }

        return false;
    }

    private function addMetaQueryArray( $meta_query_array, $relation = false )
    {
        if( ! isset( $meta_query_array['key'] ) ){
            return false;
        }

        $existing_meta_query = $this->new_meta_query;
        foreach( $existing_meta_query as $index => $present_query ){

            if( $this->hasNestedQueries( $present_query ) ){
                foreach ( $present_query as $k => $nested_present_query ){
                    if( ! isset( $nested_present_query['key'] ) ){
                        // relation arg
                        continue;
                    }
                    if( $this->isTheSameMetaQuery( $nested_present_query, $meta_query_array ) ){
                        return false;
                    }
                }
            }else{
                if( $this->isTheSameMetaQuery( $present_query, $meta_query_array ) ){
                    return false;
                }
            }

        }

        if( $relation && in_array( $relation, array( 'AND', 'OR' ) ) ){
            $index = $this->findNestedIndexForQuery($meta_query_array);
            $this->new_meta_query[$index][] = $meta_query_array;
            $this->new_meta_query[$index]['relation'] = $relation;
        }else{
            $this->new_meta_query[] = $meta_query_array;
        }

    }

    private function findNestedIndexForQuery( $meta_query_array )
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

    private function hasNestedQueries( $meta_query )
    {
        if( isset( $meta_query[0]['key'] ) ){
            return true;
        }

        return false;
    }

    private function addMetaKeyToQuery( $wp_query ){
        $args = [];

        $args['key']   = $wp_query->get( 'meta_key' );
        $args['value'] = $wp_query->get( 'meta_value' );
        $args['compare'] = ( $compare = $wp_query->get( 'meta_compare' ) ) ? $compare : 'IN';

        $wp_query->set( 'meta_key', '' );
        $wp_query->set( 'meta_value', '' );

        $this->addMetaQueryArray( $args );
    }

    private function isMetaValueSerialized( $metaKey )
    {
        global $wpdb;

        $sql = "SELECT {$wpdb->postmeta}.meta_value FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_key = %s";
        $sql .= " LIMIT 0,1";
        $sql = $wpdb->prepare( $sql, $metaKey );

        $result = $wpdb->get_results( $sql );

        if( ! empty( $result ) && isset( $result[0]->meta_value ) ){
            return is_serialized( $result[0]->meta_value );
        }

        return false;
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
    public function addTermsToWpQuery( $queried_value, $wp_query ){

        // Add existing Meta Query if present
        $this->importExistingMetaQuery($wp_query);

        $serialized = $this->isMetaValueSerialized( $queried_value['e_name'] );

        // Serialized data stored in meta_value should be matched by regexp
        if( $serialized ){
            // For multiple queries we have to set correct relation
            if( count( $queried_value['values'] ) > 1 ){
                $relation = ( $queried_value['logic'] === 'and' ) ? 'AND' : 'OR';

                foreach ( $queried_value['values'] as $slug ) {
                    $term = $this->getTerm($slug);
                    $this->addMetaQueryArray(
                        array(
                            'key'     => $queried_value['e_name'],
                            'value'   => '.*;s:[0-9]+:"'.$term->meta_value.'".*',
                            'compare' => 'REGEXP'
                        ),
                        $relation
                    );
                }

            }else{
                // Single term selected in filter
                foreach ( $queried_value['values'] as $slug ) {
                    $term = $this->getTerm($slug);
                    $this->addMetaQueryArray(
                        array(
                            'key'     => $queried_value['e_name'],
                            'value'   => '.*;s:[0-9]+:"'.$term->meta_value.'".*',
                            'compare' => 'REGEXP'
                        )
                    );
                }
            }

        }else{
            // If data stored as stings
            if( $queried_value['logic'] === 'and' ){
                foreach ( $queried_value['values'] as $slug ) {
                    $term = $this->getTerm($slug);
                    $this->addMetaQueryArray(
                        array(
                            'key'     => $queried_value['e_name'],
                            'value'   => $term->meta_value,
                            'compare' => '='
                        )
                    );
                }
            } elseif ( $queried_value['logic'] === 'or' ){
                $meta_values = [];
                foreach ( $queried_value['values'] as $slug ){
                    $term = $this->getTerm($slug);
                    $meta_values[] = $term->meta_value;
                }
                $this->addMetaQueryArray(
                    array(
                        'key'     => $queried_value['e_name'],
                        'value'   => $meta_values,
                        'compare' => 'IN'
                    )
                );
            }

        }

        if( count($this->new_meta_query) > 1 ){
            $this->new_meta_query['relation'] = 'AND';
        }

        $wp_query->set('meta_query', $this->new_meta_query );
        $this->new_meta_query = [];

        return $wp_query;
    }
}