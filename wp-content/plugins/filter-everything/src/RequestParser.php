<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class RequestParser
{
    private $request;

    private $queryVars = [];

    private $separator;

    public function __construct( $request )
    {
        $this->setRequest( $request );
        $this->separator    = FLRT_PREFIX_SEPARATOR;
    }

    private function initQueryVars(){
        // Setup default $queryVars
        $this->queryVars = array(
            'queried_values'        => [],
            'segments_order'        => [],
            'wpc_logic_separators'  => [],
            'non_filter_segments'   => [],
            'error'                 => '',
        );
    }

    public function getQueryVars(){
        $this->initQueryVars();
        $this->parseRequest();
        $this->validateQueryVars();
        return $this->queryVars;
    }

    private function isSlugInRequest( $slug ){
        return ( $this->isSlugInQuery( $slug ) || $this->isSlugInPath( $slug ) );
    }

    public function detectFilterRequest(){
        $em = Container::instance()->getEntityManager();
        foreach ( $em->getGlobalConfiguredSlugs() as $entity_slug ){
            if( $this->isSlugInRequest( $entity_slug ) ){
                return true;
            }
        }
        return false;
    }

    private function isSlugInPath( $entity_slug ){
        if( mb_strpos( '/' . $this->request, '/' . $entity_slug . $this->separator ) !== false ){
            return true;
        }
        return false;
    }

    private function isSlugInQuery( $entity_slug ){
        if(
            ( $this->queryStringParam( 'max_' . $entity_slug ) !== false )
            ||
            ( $this->queryStringParam( 'min_' . $entity_slug ) !== false )
            ||
            ( $this->queryStringParam( $entity_slug ) !== false )
        ){
            return true;
        }
        return false;
    }

    /**
     * Result always must be checked for !== false because 0 may be returned
     * @param $key [max_{slug}|min_{slug}|{slug}]
     * @return false|mixed
     */
    public function queryStringParam( $key )
    {
        $container  = Container::instance();
        $em         = $container->getEntityManager();
        $get        = $container->getTheGet();
        $post       = $container->getThePost();

        if( isset( $post['flrt_ajax_link'] ) ){
            $parts = parse_url( $post['flrt_ajax_link'] );

            if( isset( $parts['query'] ) ){
                parse_str( $parts['query'], $output );
                if( isset( $output[$key] ) ){
                    return $this->urlEncodeGetValues( $output[$key] );
                }
            }
        }

        if( isset( $get[$key] ) ){
            return $this->urlEncodeGetValues( $get[$key] );
        }

        return false;
    }

    private function urlEncodeGetValues( $values )
    {
        $queriedValues  = explode( FLRT_QUERY_TERMS_SEPARATOR, $values );
        $queriedValues  = array_map( 'urlencode', $queriedValues );
        $queriedValues  = array_map( 'mb_strtolower', $queriedValues );

        return implode(FLRT_QUERY_TERMS_SEPARATOR, $queriedValues);
    }

    private function extractValuesFromQuery( $slug ){
        $em     = Container::instance()->getEntityManager();
        $filter = $em->getFilterBySlug( $slug, array( 'entity' ) );

        $values = [];
        // Matches numbers and decimal separator
        $regexp = '/^([\-]?\d+(?:[\.\,]\d{1,})?)$/';

        if( ( $this->queryStringParam( 'max_' . $slug ) !== false ) && $filter['entity'] === 'post_meta_num' ){
            preg_match($regexp, $this->queryStringParam( 'max_' . $slug ), $output);
            $values['max'] = isset( $output[1] ) ? $output[1] : false;
        }

        if( ( $this->queryStringParam( 'min_' . $slug ) !== false ) && $filter['entity'] === 'post_meta_num' ){
            preg_match($regexp, $this->queryStringParam( 'min_' . $slug ), $output);
            $values['min'] = isset( $output[1] ) ? $output[1] : false;
        }

        if( ( $this->queryStringParam( $slug ) !== false ) ){
            if( $filter['entity'] !== 'post_meta_num' ){
                $params = $this->queryStringParam( $slug );
                $values = $this->extractQueriedValuesFromQueryString( $params, $slug );
            }else{
                $values[] = $this->queryStringParam( $slug );
            }

        }

        unset($em);

        return $values;
    }

    private function set_404( $message = '' ){
        $this->queryVars['error'] = '404';
        if( $message && FLRT_PLUGIN_DEBUG ){
            echo esc_html( $message );
        }
    }

    public function getRequest(){
        return $this->request;
    }

    public function setRequest( $request ){
//        $this->request = urldecode( strtolower( trim( $request, '/' ) ) );
        $this->request = strtolower( trim( $request, '/' ) );
    }

    /**
     * @return array
     */
    private function getPathSegments(){
        if( $this->request ){
            return explode('/', $this->request );
        }
        return [];
    }

    public function cleanUpRequestPathFromFilterSegments( $request_path ){
        // Otherwise it will be URL encoded and uppercase
        $request_path = strtolower($request_path);

        foreach( $this->getPathSegments() as $segment ){
            if( $this->checkSlugInSegmentForCleaningNativePath( $segment ) ){
                /**
                 *@improvement Maybe remove query_args also
                 */
                $request_path = str_replace('/' . $segment, '', $request_path );
            }
        }

        return $request_path;
    }

    public function parseRequest(){
        /**
         * @bug this method fires twice.
         */
        $pathSegments = $this->getPathSegments();
        $em           = Container::instance()->getEntityManager();
        $fse          = Container::instance()->getFilterService();
        // Path values
        foreach( $pathSegments as $segment ){

            if( $slug = $this->getSlugFromSegment( $segment ) ){
                $segmentParams = $this->cutParamsFromSegment( $segment, $slug );
                // List of entity, e_name, slug should be unique for all filters
                $filter_entity = $em->getFilterBySlug( $slug, array('entity', 'e_name', 'slug', 'in_path') );

                $filter_entity['values'] = $this->extractQueriedValuesFromSegment( $segmentParams, $slug );
                $filter_entity['founded_in_path'] = 'yes';
                $this->queryVars['queried_values'][$slug] = $filter_entity;

                $order_element = $fse->getEntityFullName( $filter_entity['entity'], $filter_entity['e_name'] );

                $this->queryVars['segments_order'][] = $order_element;
            } else {
                $this->queryVars['non_filter_segments'][] = $segment;
            }
        }

        // Query string values
        foreach( $em->getConfiguredQuerySlugs() as $slug ){

            if( $this->isSlugInQuery( $slug ) ){
                $filter_entity = $em->getFilterBySlug( $slug, array('entity', 'e_name', 'slug', 'in_path') );
                $filter_entity['values'] = $this->extractValuesFromQuery( $slug );
                $filter_entity['founded_in_path'] = 'no';
                $this->queryVars['queried_values'][$slug] = $filter_entity;
            }
        }

        unset($em, $fse);
    }

    private function checkSlugInSegmentForCleaningNativePath( $segment ){
        $em = Container::instance()->getEntityManager();
        foreach( $em->getConfiguredPathSlugs() as $key => $slug ){
            if( mb_strpos( $segment, $slug . $this->separator ) === 0 ){
                return $slug;
            }
        }
        return false;
    }

    private function getSlugFromSegment( $segment ){
        $em = Container::instance()->getEntityManager();
        foreach( $em->getConfiguredPathSlugs() as $key => $slug ){
            if( mb_strpos( $segment, $slug . $this->separator ) === 0 ){
                return $slug;
            }
        }
        return false;
    }

    private function cutParamsFromSegment( $segment, $slug ){
        return mb_substr( $segment, mb_strlen( $slug . $this->separator ) );
    }

    private function checkValuesOrder( $segmentParams, $sep ){
        $fse   = Container::instance()->getFilterService();
        $terms = explode( $sep, $segmentParams );
        $terms = $fse->sortTerms($terms);
        $sortedParams = implode( $sep, $terms );

        if( $segmentParams !== $sortedParams ){
            return false;
        }

        return true;
    }

    /**
     * @param string $segmentParams specially formatted sting like two#or#or-or-three#and
     * @param array $filters filters arrays with logic value
     */
    private function extractLogicSeparator( $segmentParams, $filters ){
        $fse = Container::instance()->getFilterService();
        foreach( $filters as $filter ){
            $logicSeparator = $fse->getLogicSeparator( $filter ); // -or- | -and-
            if( mb_strpos( $segmentParams, $logicSeparator ) !== false ){
                $this->queryVars['wpc_logic_separators'][$filter['slug']] = $filter['logic'];
                return $logicSeparator;
            }
        }

        return false;
    }

    private function extractQueriedValuesFromQueryString( $filterParams, $slug ){
        // $filterParams = accessories;tshirts
        $em             = Container::instance()->getEntityManager();
        $allEntityTerms = $em->getEntityAllTermsSlugs( $slug );
        $queriedValues  = $em->safeExplodeFilterValues( $filterParams, $slug, FLRT_QUERY_TERMS_SEPARATOR );
        $queriedValues  = $em->safeImplodeFilterValues( $queriedValues, FLRT_QUERY_TERMS_SEPARATOR );

        foreach ( $queriedValues as $k => $value ) {

            if ( ! in_array($value, $allEntityTerms) ) {
                unset( $queriedValues[$k] );
                $this->set_404( 'Term does not exist - ' . $value );
            }
        }

        // Check duplicates
        if( flrt_array_contains_duplicate( $queriedValues ) ){
            $this->set_404('Param duplicates');
            $queriedValues = array_unique($queriedValues);
        }

        unset( $em );

        return $queriedValues;
    }

    /**
     * @param string $segmentParams
     * @param string $slug
     * @return false|array
     */
    private function extractQueriedValuesFromSegment( $segmentParams, $slug ){

        $em = Container::instance()->getEntityManager();
        $allEntityTerms = $em->getEntityAllTermsSlugs( $slug );

        // TEMPORARY
        //$allEntityTerms = array_map( 'urldecode', $allEntityTerms );

        $filters        = $em->getAllFiltersBySlug( $slug, array( 'logic', 'slug' ) );

        $segmentParams  = $em->safeExplodeFilterValues( $segmentParams, $slug, $this->separator, false );
        $logicSeparator = $this->extractLogicSeparator( $segmentParams, $filters );

        // $segmentParams = two#or#or-or-three#and
        // $valueSeparator = '-or-'
        if( $logicSeparator ) {

            $queriedValues = explode( $logicSeparator, $segmentParams );

            if ( ! $this->checkValuesOrder($segmentParams, $logicSeparator) ) {
                /**
                 * @feature maybe redirect to URL with correct order of values
                 */
                $this->set_404('Invalid params order');
            }
        }else{
            $queriedValues[0] = $segmentParams;
        }

        $queriedValues = $em->safeImplodeFilterValues( $queriedValues, $this->separator );

        foreach ( $queriedValues as $k => $value ) {
            if ( ! in_array( $value, $allEntityTerms) ) {
                unset( $queriedValues[$k] );
                $this->set_404( 'Term does not exist - ' . $value );
            }
        }

        // Check duplicates
        if( flrt_array_contains_duplicate( $queriedValues ) ){
            $this->set_404('Param duplicates');
            $queriedValues = array_unique($queriedValues);
        }

        unset($em);

        return $queriedValues;
    }

    private function validateSegmentsOrder( $template = [] ){
        $fse          = Container::instance()->getFilterService();

        if( ! $template ){
            $template = $fse->getFiltersOrder();
        }

        $to_compare = $this->queryVars['segments_order'];

        if( flrt_array_contains_duplicate( $to_compare ) ){
            return false;
        }

        if( ! is_array( $template ) || ! is_array( $to_compare ) ){
            return false;
        }

        $new_template = array_intersect( $template, $to_compare );

        if( empty( $new_template ) ){
            return false;
        }

        $new_template       = array_values( $new_template );
        $already_compared   = [];
        $i = 0;

        foreach ( $to_compare as $index => $value ) {
            if( in_array( $value, $already_compared ) ){
                $existing_index = array_search( $value, $already_compared );
                $existing_index++;
                if( isset( $already_compared[$existing_index] ) ){
                    return false;
                }
            }

            if( $value === $new_template[$i] ){
                $i++;
                $already_compared[] = $value;
            }
        }

        unset( $fse );

        return ( $new_template === $already_compared );

    }

    private function validateQueryVars(){
        // Check for segments duplicates
        $maybe_duplicates = [];
        $fse              = Container::instance()->getFilterService();

        if( ! empty( $this->queryVars['queried_values'] ) ){
            foreach( $this->queryVars['queried_values'] as $filter ){
                $maybe_duplicates[] = $fse->getEntityFullName( $filter['entity'], $filter['e_name'] );
            }

            if( flrt_array_contains_duplicate( $maybe_duplicates ) ){
                $this->set_404( 'Segment duplicates' );
            }
        }

        // Check segments order
        if( ! empty( $this->queryVars['segments_order'] ) ) {
            if (!$this->validateSegmentsOrder()) {
                $this->set_404('Invalid segments order');
            }
        }

        unset( $fse );
        // Check something other
        // If max < than min maybe should be an error
    }
}