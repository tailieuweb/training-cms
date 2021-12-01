<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class AuthorEntity implements Entity
{
    public $excludedTerms = [];

    private $name = '';

    private $postTypes = [];

    public function __construct( $name, $postType ){
        $this->name = $name;

        if( $postType ){
            $this->setPostTypes( array( $postType ) );
        }

        $this->getAllExistingTerms();
    }

    public function setPostTypes( $postTypes )
    {
        $this->postTypes = $postTypes;
    }

    public function setExcludedTerms( $excludedTerms )
    {
        $this->excludedTerms = $excludedTerms;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTermId( $termSlug )
    {
        foreach ( $this->getAllExistingTerms() as $term ){
            if( $termSlug == $term->slug ){
                return $term->term_id;
            }
        }

        return false;
    }

    function populateTermsWithPostIds( $setId, $post_type )
    {
        foreach( $this->items as $index => $term ){

            foreach( $term->post_types as $post_id => $term_post_type ){
                if( $term_post_type !== $post_type ){
                    $position = array_search( $post_id, $term->posts );
                    unset( $this->items[$index]->posts[$position] );
                }
            }
        }
    }

    public function getTerm( $id ){
        if( ! $id ){
            return false;
        }

        foreach ( $this->getAllExistingTerms() as $term ){
            if( $id == $term->term_id ){
                return $term;
            }
        }

        return false;
    }

    public function getTerms()
    {
        return $this->excludeTerms( $this->getAllExistingTerms() );
    }

    function excludeTerms( $terms )
    {
        $exclude = [];

        if( ! empty( $this->excludedTerms ) ){
            $exclude = $this->excludedTerms;
        }

        // Exclude author if it already exists in wp_query
        // Would be better to create hook and apply this code in another place
        $wpManager          = Container::instance()->getWpManager();
        $wp_queried_object  = $wpManager->getQueryVar( 'wp_queried_object' );
        if( isset( $wp_queried_object['author'] ) ){
            $exclude[] = $this->getTermId( $wp_queried_object['author'] );
        }

        foreach( $terms as $index => $term ){
            if( in_array( $term->term_id, $exclude ) ){
                unset( $terms[$index] );
            }
        }

        return $terms;
    }

    /**
     * @return array list of term_id and names useful to create Select dropdown
     */
    public function getTermsForSelect()
    {
        $toSelect = [];
        foreach ( $this->getTerms() as $term ) {
            $toSelect[$term->term_id] = $term->name;
        }

        return $toSelect;
    }

    public function getTermsForSelect2()
    {
        $toSelect = [];
        foreach ( $this->getTerms() as $term ) {
            $toSelect[] = array( 'id' => $term->term_id, 'text' =>$term->name );
        }

        return $toSelect;
    }

    function getAllExistingTerms($force = false)
    {
        if( empty( $this->items ) || $force ) {
            $this->items = $this->getAuthors();
        }

        return $this->items;
    }

    private function getAuthors()
    {
        $transient_key = flrt_get_terms_transient_key( $this->getName() );

        if ( false === ( $result = get_transient( $transient_key ) ) ) {

            global $wpdb;
            $this->postTypes = apply_filters('wpc_filter_author_query_post_types', get_post_types(array('public' => true)));

            $IN = [];

            if (!empty($this->postTypes)) {
                foreach ($this->postTypes as $postType) {
                    $pieces[] = $wpdb->prepare("%s", $postType);
                }

                $IN = implode(", ", $pieces);
            }

            $sql[] = "SELECT {$wpdb->users}.ID,{$wpdb->users}.user_nicename,{$wpdb->users}.display_name,{$wpdb->posts}.post_type,{$wpdb->posts}.ID AS post_id";
            $sql[] = "FROM {$wpdb->users}";
            $sql[] = "LEFT JOIN {$wpdb->posts} ON ( {$wpdb->users}.ID = {$wpdb->posts}.post_author )";

            if (flrt_wpml_active() && defined('ICL_LANGUAGE_CODE')) {
                $sql[] = "LEFT JOIN {$wpdb->prefix}icl_translations AS wpml_translations";
                $sql[] = "ON {$wpdb->posts}.ID = wpml_translations.element_id";

                if (!empty($this->postTypes)) {

                    $sql[] = "AND wpml_translations.element_type IN(";

                    foreach ($this->postTypes as $type) {
                        $LANG_IN[] = $wpdb->prepare("CONCAT('post_', '%s')", $type);
                    }
                    $sql[] = implode(",", $LANG_IN);

                    $sql[] = ")";

                }
            }

            $sql[] = "WHERE 1=1";

            if (!empty($IN)) {
                $sql[] = "AND {$wpdb->posts}.post_type IN( {$IN} )";
            }

            $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";

            if (flrt_wpml_active() && defined('ICL_LANGUAGE_CODE')) {
                $sql[] = $wpdb->prepare("AND wpml_translations.language_code = '%s'", ICL_LANGUAGE_CODE);
            }

            $sql[] = "ORDER BY {$wpdb->users}.ID ASC";
            $sql = implode(' ', $sql);

            $result = $wpdb->get_results($sql, ARRAY_A);

            set_transient( $transient_key, $result, FLRT_TRANSIENT_PERIOD_HOURS * HOUR_IN_SECONDS );
        }

        return $this->convertToStandardTerms($result);;
    }

    private function convertToStandardTerms( $users ){
        $terms = [];

        if( ! is_array( $users ) ){
            return $terms;
        }

        // To make standard format for terms array;
        foreach ( $users as $index => $user ){

            $user_id = $user['ID'];

            if( isset( $terms[ $user_id ] ) ){
                $terms[ $user_id ]->posts[] = $user['post_id'];
                $terms[ $user_id ]->count++;
                $terms[ $user_id ]->post_types[$user['post_id']] = $user['post_type'];
            }else{
                $termObject             = new \stdClass();
                $termObject->slug       = $user['user_nicename']; // slug for URL
                $termObject->name       = apply_filters( 'wpc_filter_author_term_name', $user['display_name'], $this->getName() ); // Name to display
                $termObject->term_id    = $user_id; // Term ID.
                $termObject->posts      = array( $user['post_id'] ); // All post IDs for this term (in all post types)
                $termObject->count      = 1; // Total count of posts for this term (in all post types)
                $termObject->cross_count = 0; // Count of this term intersect posts with all filtered posts
                $termObject->post_types[$user['post_id']] = $user['post_type']; // map terms post_types and their IDs

                $terms[ $user_id ] = $termObject;
            }
        }

        return $terms;
    }

    /**
     * @param $queried_value
     * @param $wp_query
     * @return mixed object WP_Query | false
     */
    function addTermsToWpQuery( $queried_value, $wp_query )
    {
        $author__in = [];
        $em             = Container::instance()->getEntityManager();
        $post_type      = isset( $this->postTypes[0] ) ? $this->postTypes[0] : '';
        $authorEntity   = $em->createEntity( 'author#author', $post_type );

        // if author already exists in query we have to return false
        $maybeAlreadyExists = $wp_query->get( 'author_name' );
        if( in_array( $maybeAlreadyExists, $queried_value['values'], true ) ){
            /**
             * @todo replace with with just false. Or better - show this only in debug mode.
             */
            return 'Author is already in query';
        }

        if( $maybeAlreadyExists ){
            $queried_value['values'][] = $maybeAlreadyExists;
            $wp_query->set( 'author_name', '');
            $wp_query->set( 'author', $authorEntity->getTermId($maybeAlreadyExists) );
        }

        foreach ( $queried_value['values'] as $user_nicename ) {
            $author__in[] = $authorEntity->getTermId($user_nicename);
        }

        $wp_query->set( 'author__in', $author__in );

        // If ok return $wp_query;
        return $wp_query;
    }
}