<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class UrlManager
{
    private $separator;

    private $order;

    private $resetUrl;

    private $logicParam = 'logic'; // Should be an option

    private $valuesSeparator = FLRT_QUERY_TERMS_SEPARATOR; // Should be an option

    public function __construct()
    {
        $this->separator        = FLRT_PREFIX_SEPARATOR;
        $fse                    = Container::instance()->getFilterService();
        $this->order            = $fse->getFiltersOrder();
        $this->permalinksOn     = defined('FLRT_PERMALINKS_ENABLED') ? FLRT_PERMALINKS_ENABLED : false;

        if( $this->permalinksOn ){
            add_filter( 'wpc_filter_term_url', array( $this, 'processPermalink' ) );
        }

        unset( $fse );
    }

    public function processPermalink( $url )
    {
        $em    = Container::instance()->getEntityManager();
        $parts = explode('?', $url);

        if (count($parts) !== 2) {
            return $url;
        }

        list($path, $get) = $parts;

        $query = [];
        $parts = [];

        parse_str( $get, $query );

        foreach( $this->getEnamesOrder() as $entityName ){

            $filter = $em->getFilterBy( 'e_name', $entityName, array( 'slug', 'e_name', 'logic', 'in_path' ) );

            if( ! $filter || empty( $filter ) || ( $filter['in_path'] !== 'yes' ) ){
                continue;
            }

            if( isset( $query[ $filter['slug'] ] ) ){

                $termSlugs = $em->safeExplodeFilterValues( $query[ $filter['slug'] ], $filter['slug'], $this->getValuesSeparator() );
                $termSlugs = $em->safeImplodeFilterValues( $termSlugs, $this->getValuesSeparator() );

                $parts[] = $this->buildFilterSegment( $termSlugs, $filter );
            }

            unset( $query[ $filter['slug'] ] );
            unset( $query[ $this->getLogicParamName( $filter['slug'] ) ] );
        }

        $path = trailingslashit( $path ) . implode('/', $parts );
        $path = user_trailingslashit( $path );

        $url = flrt_add_query_arg( $query, $path );

        unset($em);

        return $url;
    }

    private function getEnamesOrder()
    {
        $e_namesOrder = [];
        $fse          = Container::instance()->getFilterService();

        foreach( $this->order as $entityName ){
            $e_namesOrder[] = $fse->getEntityEname( $entityName );
        }

        unset( $fse );

        return $e_namesOrder;
    }

    public function getSubArrayBy( $byKey, $value, &$array )
    {
        foreach ( $array as $index => $subArray ) {
            if( isset( $subArray[ $byKey ] ) && $subArray[ $byKey ] === $value ){
                return $subArray;
            }
        }

        return false;
    }

    public function getFormActionUrl( $queryParams = false )
    {
        $query          = [];
        $homeUrl        = parse_url(home_url());
        $post           = Container::instance()->getThePost();
        $requestedUri   = isset( $post['flrt_ajax_link'] ) ? $post['flrt_ajax_link'] :  $homeUrl['scheme'].'://'.$homeUrl['host'] . $_SERVER['REQUEST_URI'];

        $pieces         = parse_url( $requestedUri );
        $fullPath       = $pieces['scheme']."://".$pieces['host'].$pieces['path'];

        if( isset( $pieces['query'] ) ){
            parse_str( $pieces['query'], $query );
        }

        $formAction = preg_replace('%\/page/[0-9]+%', '', $fullPath);
        $formAction = preg_replace('%\/comment\-page\-[0-9]+%', '', $formAction);
        $formAction = preg_replace('%\/[0-9]+[\/]?$%m', '', $formAction);

        $formAction = FLRT_PERMALINKS_ENABLED ? user_trailingslashit( $formAction ) : rtrim( $formAction, '/' ) . '/';

        // Add GET parameters
        if( $queryParams && ! empty( $query )) {
            foreach ($query as $name => $value) {
                $formAction = flrt_add_query_arg($name, $value, $formAction);
            }
        }

        return $formAction;
    }

    private function setCorrectGetKeys( $queried_values )
    {
        $getKeys = [];
        if( ! $queried_values || empty($queried_values) ){
            return apply_filters( 'wpc_unnecessary_get_parameters', $getKeys );
        }

        foreach ( $queried_values as $slug => $filter ){
            if( $filter['entity'] === 'post_meta_num' ){
                $getKeys['max_'.$slug] = $filter;
                $getKeys['min_'.$slug] = $filter;
            }else{
                $getKeys[$slug] = $filter;
            }
        }

        return apply_filters( 'wpc_unnecessary_get_parameters', $getKeys );
    }

    public function getResetUrl()
    {
        if( ! $this->resetUrl ) {
            $container      = Container::instance();
            $wpManager      = $container->getWpManager();
            $get            = $container->getTheGet();

            // For compatibility with some Nginx configurations
            unset($get['q']);

            $this->resetUrl = home_url( $wpManager->getQueryVar('wp_request') );
            $requested = $wpManager->getQueryVar('queried_values', [] );
            $pos = strpos($this->resetUrl, '/page');

            if ($pos !== false) {
                $this->resetUrl = substr($this->resetUrl, 0, $pos);
            }

            $this->resetUrl = preg_replace('%\/[0-9]+[\/]?$%m', '', $this->resetUrl);

            $this->resetUrl = FLRT_PERMALINKS_ENABLED ? user_trailingslashit( $this->resetUrl ) : rtrim( $this->resetUrl, '/' ) . '/';

            // Maybe add GET parameters
            if( ! empty( $get ) ){

                foreach ( $get as $name => $value ) {

                    if( ! in_array( $name, array_keys( $this->setCorrectGetKeys( $requested ) ) ) ){
                        $this->resetUrl = add_query_arg( $name, $value, $this->resetUrl );
                    }
                }
            }

        }

        return $this->resetUrl;
    }

    public function getValuesSeparator()
    {
        return $this->valuesSeparator;
    }

    public function getLogicParamName( $slug )
    {
        return $this->getParamName( $slug ).'_'.$this->logicParam;
    }

    public function getParamName( $slug )
    {
        return sanitize_title( $slug );
    }

    private function getSingleActualFilter($e_name )
    {
        $em    = Container::instance()->getEntityManager();
        $filter = $em->getFilterBy( 'e_name', $e_name, array( 'slug', 'e_name', 'logic' ) );
        $filter['values'] = [];

        unset( $em );

        return $filter;
    }

    public function getFiltersUrl( $filters )
    {
        $url = $this->getResetUrl();
        $fse = Container::instance()->getFilterService();

        if( ! empty( $filters ) ){

            foreach( $filters as $filter ){

                if( ! empty( $filter['values'] ) ){
                    $filter['values'] = $fse->sortTerms( $filter['values'] );

                    if( $filter['entity'] === 'post_meta_num' ){

                        foreach( $filter['values'] as $edge => $value ){
                            $paramName = $edge.'_'.$filter['slug'];
                            $url = flrt_add_query_arg( $this->getParamName( $paramName ) , $value, $url );
                        }

                    } else {
                        $url = flrt_add_query_arg( $this->getParamName( $filter['slug'] ) , implode( $this->getValuesSeparator(), $filter['values'] ), $url );
                    }

                }

            }
        }

        unset( $fse );

        return apply_filters( 'wpc_filter_term_url', $url );
    }

    public function getTermUrl( $termSlug, $e_name )
    {
        $em    = Container::instance()->getEntityManager();
        $filtersCombination = [];
        $actualFilters = $em->getSetsRelatedFilters();

        if( empty( $actualFilters ) ){
            $actualFilters[] = $this->getSingleActualFilter( $e_name );
        }

        foreach($this->getEnamesOrder() as $entityName ){

            if( $filter = $this->getSubArrayBy( 'e_name', $entityName, $actualFilters ) ) {

                $queriedValues = $filter['values'];

                if( $e_name === $entityName ){
                    // Add only single filter value for views with single selection
                    if( in_array( $filter['view'], array('dropdown', 'radio') ) ){

                        if( in_array( $termSlug, $queriedValues ) ){
                            $position = array_search( $termSlug, $queriedValues );
                            unset( $queriedValues[$position] );
                        }else{
                            $queriedValues = array( $termSlug );
                        }

                    } else {
                        // For Post Meta Num values have array index as termslug
                        if( $filter['entity'] === 'post_meta_num' ){

                            if( in_array( $termSlug, array_keys( $queriedValues ) ) ){
                                unset( $queriedValues[$termSlug] );
                            }else{
                                $queriedValues[] = $termSlug;
                            }

                        }else{

                            if( in_array( $termSlug, $queriedValues ) ){
                                $position = array_search( $termSlug, $queriedValues );
                                unset( $queriedValues[$position] );
                            }else{
                                $queriedValues[] = $termSlug;
                            }

                        }

                    }
                }

                $filter['values'] = $queriedValues;
                $filtersCombination[] = $filter;
            }
        }

        unset($em);

        // URL already escaped
        return $this->getFiltersUrl( $filtersCombination );
    }

    private function buildFilterSegment( $termSlugs, $filter ){
        $segment = $filter['slug'] . $this->separator;
        $fse     = Container::instance()->getFilterService();

        if( ! is_array( $termSlugs ) ){
            return false;
        }

        /**
         * @bug if filter is present in two sets logic gets incorrect
         */

        $termSlugs = array_map('urlencode', $termSlugs);

        $termSlugs  = $fse->sortTerms( $termSlugs );
        $terms      = implode( $fse->getLogicSeparator( $filter ), $termSlugs );
        $segment    .= $terms;

        unset($fse);

        return $segment;
    }
}