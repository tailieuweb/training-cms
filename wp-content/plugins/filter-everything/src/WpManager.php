<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class WpManager
{
    private $requestParser;

    private $filterQueryVars;

    private $isFilterRequest;

    private $em;

    public function init()
    {
        global $wp_rewrite;

        $rewrite = $wp_rewrite->wp_rewrite_rules();
        $permalinksEnabled = ( defined( 'FLRT_FILTERS_PRO' ) && ! empty( $rewrite ) );
        define( 'FLRT_PERMALINKS_ENABLED', $permalinksEnabled );

        $this->requestParser = new RequestParser( $this->prepareRequest() );
        $this->em = Container::instance()->getEntityManager();
    }

    public function parseRequest($WP)
    {
        if ($this->requestParser->detectFilterRequest()) {
            foreach ($this->requestParser->getQueryVars() as $key => $queryVar) {
                $this->setQueryVar($key, $queryVar);
            }

            $this->isFilterRequest = true;
            $this->setQueryVar('wpc_is_filter_request', true);

            if ($this->getQueryVar('error') === '404') {
                $WP->set_query_var('error', '404');
                return false;
            }

            remove_action( 'template_redirect', 'redirect_canonical' );
        }
    }

    public function addFilterQueryToWpQuery($wp_query)
    {
        // The main difference is that we need to detect relevantSetId:
        // - one time and store it into Container
        // - do it before comparing with the current query
        global $wpc_not_fired;
        $this->collectWPQueries($wp_query);

        if ( $wp_query->is_main_query() && $wpc_not_fired ) {
            global $flrt_sets;

            $filterSet = Container::instance()->getFilterSetService();

            // Set global filters vars
            $this->setQueryVar('wp_queried_object', $this->identifyWpQueriedObject($wp_query) );
            $sets = $filterSet->findRelevantSets( $this->getQueryVar('wp_queried_object') );

            // Save sets in global var
            $flrt_sets = $sets;
            $this->setQueryVar('wpc_page_related_set_ids', $sets);

            // We need to set allowed_filter_page dependently from relevant set id
            $this->setQueryVar('allowed_filter_page', $this->isAllowedFilterPage());

            do_action( 'wpc_related_set_ids', $sets );

            if( $this->isFilterRequest() ){

                if (!$this->getQueryVar('allowed_filter_page')) {
                    self::make_404($wp_query, 'Not allowed filters page'); // Fires 301 redirect if is singular
                    return true;
                }

                if (!$filterSet->validateSets($sets)) {
                    self::make_404($wp_query, 'Invalid Set Ids');
                    return true;
                }

                /**
                 * We couldn't do this earlier because we didn't know
                 * what exact filter set was queried for this post type.
                 * We only knew, that some filter with some exact slug was
                 * requested.
                 */
                // Here we should fill queried_values with correct logic
                if ( ! $this->populateQueriedValuesWithAdditionalParams( $sets) ) {
                    self::make_404($wp_query, 'Forbidden filter requested 2');
                    return true;
                }

                // Now we have correct logic separator in queried filter and can validate requested separators
                if (!$this->validateFiltersLogic()) {
                    self::make_404($wp_query, 'Incorrect logic separator');
                    return true;
                }

                /**
                 * Validate situations, when /param-value/ and /?param=value is not correct
                 */
                if (FLRT_PERMALINKS_ENABLED) {
                    if (!$this->validateFiltersPosition()) {
                        self::make_404($wp_query, 'Term is not in correct part of URL');
                        return true;
                    }
                }

                if (!$this->em->checkForbiddenFilters($this->getQueryVar('queried_values'), $this->em->getOnlyBelongsFilters($sets))) {
                    self::make_404($wp_query, 'Forbidden filter requested');
                    return true;
                }
            }
            // To will never fire this section of code again
            $wpc_not_fired = false;
        }

        if( ! $this->getQueryVar('allowed_filter_page') ){
            return $wp_query;
        }

        // This should be an array!
        $setIds = $this->isFilteredQuery( $wp_query );

        // if $setIds not empty it means, that current query is filtered query
        if ( ! empty( $setIds ) ){

            //Clone and store this object to use it in the future
            $to_save = clone $wp_query;
            foreach ( $setIds as $setId ){
                // If there are two or more sets related with the same $wp_query
                // It should be stored in object two or more times with different setId
                $this->setQueryVar('wpc_set_filter_query_' . $setId, $to_save);
            }
            unset($to_save);
        }

        if ( ! empty( $setIds ) && $this->isFilterRequest() ) {

            /**
             * Finally all right and we can impact core Wordpress query
             */
            $em              = Container::instance()->getEntityManager();
            $set_filter_keys = $em->getSetFilterKeys( $setIds );

            foreach ($this->getQueryVar('queried_values') as $queried_value) {
                $queried_value_key = $queried_value['entity'].'#'.$queried_value['e_name'];

                if( ! $wp_query->get('flrt_query_clone') && in_array( $queried_value_key, $set_filter_keys ) ){
                    $wpc_main_query = $this->em->addTermsToWpQuery($queried_value, $wp_query);

                    if (!($wpc_main_query instanceof \WP_Query)) {
                        return true;
                    }
                }
            }

        }
        // Filter $wp_query after adding filtering terms
        if ( ! empty( $setIds ) && ! $wp_query->get('flrt_query_clone') ) {
            do_action( 'wpc_filtered_query_end', $wp_query );
        }
    }

    private function isFilteredQuery( $query )
    {
        if( defined('FLRT_FILTERS_PRO') && FLRT_FILTERS_PRO ){
            return apply_filters( 'wpc_is_filtered_query', [], $query );
        }

        if( $query->is_main_query() ){
            $sets = $this->getQueryVar('wpc_page_related_set_ids');
            return array( $sets[0]['ID'] );
        }
    }


    /**
     * @return bool
     */
    private function validateFiltersLogic()
    {
        $queriedValues = $this->getQueryVar('queried_values');
        foreach ($this->getQueryVar('wpc_logic_separators') as $slug => $logic) {
            if ($queriedValues[$slug]['logic'] !== $logic) {
                return false;
            }
        }
        return true;
    }

    private function validateFiltersPosition()
    {
        foreach ($this->getQueryVar('queried_values') as $slug => $filterParams ) {
            if ($filterParams['in_path'] !== $filterParams['founded_in_path']) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $sets
     */
    private function populateQueriedValuesWithAdditionalParams($sets)
    {
        $queriedValues = $this->getQueryVar('queried_values');
        $relatedFilters = $this->em->getOnlyBelongsFilters($sets);

        $queriedValuesWithLogic = [];

        foreach ($relatedFilters as $filter) {
            $slug = $filter['slug'];

            if (isset($queriedValues[$slug])) {
                $queriedValuesWithLogic[$slug]                  = $queriedValues[$slug];
                $queriedValuesWithLogic[$slug]['logic']         = $filter['logic'];
                $queriedValuesWithLogic[$slug]['show_chips']    = $filter['show_chips'];
                $queriedValuesWithLogic[$slug]['in_path']       = $filter['in_path'];
                $queriedValuesWithLogic[$slug]['label']         = $filter['label'];
                $queriedValuesWithLogic[$slug]['used_for_variations'] = $filter['used_for_variations'];

                if( $filter['entity'] === 'post_meta_num' ){
                    $queriedValuesWithLogic[$slug]['step']      = $filter['step'];
                }
            }

        }

        if (count($queriedValuesWithLogic) !== count($queriedValues)) {
            // Here was self:make_404() but I moved it.
            return false;
        }

        // Hard set of filterQueryVars
        if (!empty($queriedValuesWithLogic)) {
            $this->filterQueryVars['queried_values'] = $queriedValuesWithLogic;
        }

        return true;
    }

    /**
     * @return array
     */
    public function identifyWpQueriedObject($wp_query)
    {
        $wp_queried_object = [];

        if (!is_object($wp_query)) {
            return $wp_queried_object;
        }

        // Archive pages
        if ($wp_query->is_archive()) {

            if ($wp_query->is_tax()) {
                $wp_queried_object = $this->fillQueriedTermObject($wp_query);
            }

            if ($wp_query->is_post_type_archive()) {
                $post_type_object = $wp_query->get_queried_object();
                if (isset($post_type_object->name)) {
                    $wp_queried_object['post_types'][] = $post_type_object->name;

                    // Shop page
                    if( $post_type_object->name === 'product' ){
                        $wp_queried_object['common'][] = 'shop_page';
                    }

                    if( $wp_query->is_search() ){
                        $wp_queried_object['common'][] = 'search_results';
                    }
                }

            }

            if ($wp_query->is_author()) {
                if( ! isset( $wp_queried_object['post_types'] ) ){
                    $wp_queried_object['post_types'][] = 'post';
                }

                if( $wp_query->get('author_name') ){
                    $wp_queried_object['author'] = $wp_query->get('author_name');
                } else {
                    $user_id    = $wp_query->get('author');
                    $user       = get_user_by('ID', $user_id);
                    $wp_queried_object['author'] = $user->data->user_nicename;
                }

            }

            if ($wp_query->is_date()) {
                $wp_queried_object['post_types'][] = 'post';
            }

            if ($wp_query->is_tag()) {
                $wp_queried_object = $this->fillQueriedTermObject($wp_query);
            }

            if ($wp_query->is_category()) {
                $wp_queried_object = $this->fillQueriedTermObject($wp_query);
            }
        }

        // Blog, posts page
        if ($wp_query->is_home() || $wp_query->is_posts_page ) {
            $wp_queried_object['post_types'][] = 'post';
            $wp_queried_object['common'][]     = 'page_for_posts';
        }

        // Front page (if is home page)
        // For some reason WP_Query::is_front_page() produces PHP notices so we will check is_front_page later
        if ( ! $wp_query->is_singular() && $wp_query->is_front_page() ){
            // Can be shop, archive page, static page, index page(is_home())
            $wp_queried_object['common'][] = 'page_on_front';
        }

        // Search results
        if ($wp_query->is_search() && !$wp_query->is_archive()) {
            $wp_queried_object['post_types'][] = ($wp_query->get('post_type')) ? $wp_query->get('post_type') : 'post';
            $wp_queried_object['common'][]     = 'search_results';
        }

        if( $wp_query->is_singular() ){
            /**
             * @todo add params about Homepage, Posts page (Blog), Search page, Shop page.
             * is_front_page(), is_home(),
             */

            if( $post_obj = $wp_query->get_queried_object() ){
                // It seems it works for pages only
                $wp_queried_object['post_types'][] = isset( $post_obj->post_type ) ? $post_obj->post_type : false;
                $wp_queried_object['post_id']      = isset( $post_obj->ID ) ? $post_obj->ID : false;

            }elseif( $post_type = $wp_query->get('post_type') ){

                if( is_array( $post_type ) ){
                    $wp_queried_object['post_types'] = $post_type;
                }else{
                    $wp_queried_object['post_types'][] = $post_type;
                }

                if( $name = $wp_query->get('name') ){

                    foreach ( (array) $post_type as $_post_type ) {
                        $ptype_obj = get_post_type_object( $_post_type );
                        if ( ! $ptype_obj ) {
                            continue;
                        }

                        $f_post = get_page_by_path( $name, OBJECT, $_post_type );
                        if ( isset( $f_post->post_type ) ) {
                            $wp_queried_object['post_id'] = $f_post->ID;
                            break;
                        }
                    }

                    unset( $ptype_obj );
                } elseif( $page_id = $wp_query->get('page_id') ){
                    $wp_queried_object['post_id'] = $page_id;
                }

            } elseif( $page_id = $wp_query->get('page_id') ){
                $wp_queried_object['post_types'][] = 'page';
                $wp_queried_object['post_id'] = $page_id;

            } elseif ( $post_id = $wp_query->get('p') ){
                $f_post = get_post( $post_id );
                if( isset( $f_post->post_type ) ){
                    $wp_queried_object['post_types'][]  = $f_post->post_type;
                    $wp_queried_object['post_id']       = $post_id;
                }
            }

            // When single page is front page
            if( isset( $wp_queried_object['post_id'] ) && get_option( 'page_on_front' ) === $wp_queried_object['post_id'] ){
                $wp_queried_object['common'][] = 'page_on_front';
                unset($wp_queried_object['post_id']);
            }

        }

        // Maybe Ajax Home
        $postData = Container::instance()->getThePost();
        if( isset( $postData['flrt_ajax_link'] ) && empty( $wp_queried_object ) ){
            $wp_queried_object['post_types'][] = ($wp_query->get('post_type')) ? $wp_query->get('post_type') : 'post';
        }

        return $wp_queried_object;
    }

    private function fillQueriedTermObject($wp_query)
    {
        $wp_queried_object = [];
        $term = $wp_query->get_queried_object();

        if (isset($term->taxonomy) && $term->taxonomy) {
            $taxonomy = get_taxonomy($term->taxonomy);

            $wp_queried_object['post_types'] = isset( $taxonomy->object_type ) ? $taxonomy->object_type : false;
            $wp_queried_object['taxonomy']   = isset( $term->taxonomy ) ?  $term->taxonomy : false;
            $wp_queried_object['term_id']    = isset( $term->term_id ) ? $term->term_id : false;

        }

        return $wp_queried_object;
    }

    public function isAllowedFilterPage()
    {
        return ( ! empty( $this->getQueryVar('wpc_page_related_set_ids') ) );
    }

    public function fixSearchPostType( $wpQuery )
    {
        if( $wpQuery->is_search() && $wpQuery->is_main_query() ){
            $relevantSetIds = $this->getQueryVar('wpc_page_related_set_ids' );

            if( ! empty( $relevantSetIds ) && ! $wpQuery->get('post_type') ){
                $wpQuery->set('post_type', 'any' );
            }
        }
    }

    public function fixPostsWhereForSearch( $where, $wpQuery )
    {
        if( $wpQuery->is_search() && $wpQuery->is_main_query()  ){
            $relevantSetIds = $this->getQueryVar('wpc_page_related_set_ids' );

            if( ! empty( $relevantSetIds ) ){
                if( is_user_logged_in() ){
                    global $wpdb;
                    $where = str_replace( "OR {$wpdb->posts}.post_status = 'private'", "", $where );
                }
            }
        }

        return $where;
    }

    public function getQueryVar($var, $default = false)
    {
        if (isset($this->filterQueryVars[$var])) {
            return $this->filterQueryVars[$var];
        }
        return $default;
    }

    public function setQueryVar($var, $value)
    {
        if (!isset($this->filterQueryVars[$var])) {
            $this->filterQueryVars[$var] = $value;
            return true;
        }
        return false;
    }

    public static function make_404($wp_query, $message = '')
    {
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        if ($message && FLRT_PLUGIN_DEBUG) {
            echo esc_html( $message );
        }
    }

    public function isFilterRequest()
    {
        return $this->isFilterRequest;
    }

    private function collectWPQueries( $wp_query )
    {
        if( $wp_query->is_archive() ||
            $wp_query->get( 'post_type' ) ||
            $wp_query->is_home() ||
            $wp_query->is_search()
        ) {

            if( is_admin() ){
                return $wp_query;
            }

            if( $post_type = $wp_query->get( 'post_type' ) ){
                $filterSet = Container::instance()->getFilterSetService();
                $allowedPostTypes = $filterSet->getPostTypes();

                if( ! is_array($post_type) ){
                    $post_type_array[] = $post_type;
                }else{
                    $post_type_array  = $post_type;
                }

                foreach ( $post_type_array as $single_post_type ){
                    if( ! in_array( $single_post_type, array_keys( $allowedPostTypes ) ) ){
                        return $wp_query;
                    }
                }
            }

            if( $wp_query->is_singular() ){
                return $wp_query;
            }

            // Check if it is our Filtered query and return
            if( $wp_query->get('flrt_query_clone') || $wp_query->get('flrt_set_query') ){
                return $wp_query;
            }

            global $flrt_queries;
            // We must always get post type to compare with selected Post type in Filter Set

            $flrt_query_vars = [];
            $query_label     = '';

            $flrt_query_vars['is_main_query']        = $wp_query->is_main_query();
            $flrt_query_vars['is_home']              = $wp_query->is_home();
            $flrt_query_vars['fields']               = $wp_query->get('fields');
            $flrt_query_vars['is_archive']           = $wp_query->is_archive();
            $flrt_query_vars['is_post_type_archive'] = $wp_query->is_post_type_archive();
            $flrt_query_vars['is_tax']               = $wp_query->is_tax();
            $flrt_query_vars['is_tag']               = $wp_query->is_tag();
            $flrt_query_vars['is_category']          = $wp_query->is_category();
            $flrt_query_vars['is_author']            = $wp_query->is_author();
            $flrt_query_vars['is_search']            = $wp_query->is_search();
            $flrt_query_vars['is_post__in']          = ! empty( $wp_query->get('post__in') );
            $flrt_query_vars['is_post__not_in']      = ! empty( $wp_query->get('post__not_in ') );

            if( $wp_query->is_archive() ){

                if( ! $post_type  ){
                    if( $wp_query->is_tag() || $wp_query->is_category() || $wp_query->is_tax() ){
                        $term = $wp_query->get_queried_object();
                        $tax = ( isset( $term->taxonomy ) ) ? $term->taxonomy : '';
                        $taxonomy = get_taxonomy($tax);
                        $post_type_array = isset( $taxonomy->object_type ) ? $taxonomy->object_type : [];
                    }

                    if( $wp_query->is_date() || $wp_query->is_author() ){
                        $post_type_array[] = 'post';
                    }

                }
            }

            if($wp_query->is_search()){
                $query_label .= esc_html__('Search', 'filter-everything').' ';

                if( ! $post_type  ){
                    $post_type_array[] = 'post';
                }
            }

            if( $wp_query->is_home() ){

                if( ! $post_type  ){
                    $post_type_array[] = 'post';
                }
            }

            if( ! empty( $post_type_array ) ){
                $copy_post_type_array = $post_type_array;
                $copy_post_type_array = array_map('flrt_ucfirst', $copy_post_type_array);
                $query_label .= implode(", ", $copy_post_type_array);

                $flrt_query_vars['post_types'] = $post_type_array;
            }

            $hash = md5( serialize( $flrt_query_vars ) );

            $query_label .= ' '.esc_html__('query', 'filter-everything');
            if( $wp_query->is_main_query() ){
                $query_label .= '. '.esc_html__('Main Query.', 'filter-everything');
            }

            $flrt_query_vars['label'] = $query_label;
            $to_save_query_vars = $wp_query->query_vars;

            // IN case of using Pods
            unset($to_save_query_vars['settings']);
            // To avoid problems with search query
            $to_save_query_vars['s'] = '';

            $flrt_query_vars['query_vars']  = serialize( $to_save_query_vars );
            $flrt_queries[ $hash ][]        = $flrt_query_vars;

            $currentOrder = array_key_last( $flrt_queries[ $hash ] );
            $wp_query->set( 'flrt_query_hash', md5($hash . $currentOrder ));
        }

        return $wp_query;
    }

    private function getRequestUri()
    {
        $postData = Container::instance()->getThePost();
        if( isset( $postData['flrt_ajax_link'] ) ){

            $home_url = home_url();

            if( flrt_wpml_active() ){
                $home_url = apply_filters( 'wpml_home_url', home_url() );
            }

            $parts = explode( '?', $home_url );
            $home_url = trim( $parts[0], '/' );

            $res =  str_replace( $home_url, '', $postData['flrt_ajax_link'] );
            return $res;
        }

        return $_SERVER['REQUEST_URI'];
    }

    public function customParseRequest( $do_parse_request, $WP, $extra_query_vars ){
        global $wp_rewrite;
        $postData = Container::instance()->getThePost();

        $WP->query_vars     = [];
        $post_type_query_vars = [];

        if ( is_array( $extra_query_vars ) ) {
            $WP->extra_query_vars = & $extra_query_vars;
        } elseif ( ! empty( $extra_query_vars ) ) {
            parse_str( $extra_query_vars, $WP->extra_query_vars );
        }
        // Process PATH_INFO, REQUEST_URI, and 404 for permalinks.

        // Fetch the rewrite rules.
        $rewrite = $wp_rewrite->wp_rewrite_rules();

        if ( ! empty( $rewrite ) ) {
            // If we match a rewrite rule, this will be cleared.
            $error               = '404';
            $WP->did_permalink = true;

            $pathinfo         = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
            list( $pathinfo ) = explode( '?', $pathinfo );
            $pathinfo         = str_replace( '%', '%25', $pathinfo );

            // Cleanup request path from filter segments
            $cleanedRequest  = $this->requestParser->cleanUpRequestPathFromFilterSegments( $this->getRequestUri() );

            list( $req_uri ) = explode( '?', $cleanedRequest );
            $self            = $_SERVER['PHP_SELF'];
            $home_path       = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
            $home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );

            /*
             * Trim path info from the end and the leading home path from the front.
             * For path info requests, this leaves us with the requesting filename, if any.
             * For 404 requests, this leaves us with the requested permalink.
             */
            $req_uri  = str_replace( $pathinfo, '', $req_uri );
            $req_uri  = trim( $req_uri, '/' );
            $req_uri  = preg_replace( $home_path_regex, '', $req_uri );
            $req_uri  = trim( $req_uri, '/' );
            $pathinfo = trim( $pathinfo, '/' );
            $pathinfo = preg_replace( $home_path_regex, '', $pathinfo );
            $pathinfo = trim( $pathinfo, '/' );
            $self     = trim( $self, '/' );
            $self     = preg_replace( $home_path_regex, '', $self );
            $self     = trim( $self, '/' );

            // The requested permalink is in $pathinfo for path info requests and
            // $req_uri for other requests.
            if ( ! empty( $pathinfo ) && ! preg_match( '|^.*' . $wp_rewrite->index . '$|', $pathinfo ) ) {
                $requested_path = $pathinfo;
            } else {
                // If the request uri is the index, blank it out so that we don't try to match it against a rule.
                if ( $req_uri == $wp_rewrite->index ) {
                    $req_uri = '';
                }
                $requested_path = $req_uri;
            }
            $requested_file = $req_uri;

            $WP->request = $requested_path;
            $this->setQueryVar('wp_request', $requested_path);
            // Look for matches.
            $request_match = $requested_path;

            if ( empty( $request_match ) ) {
                // An empty request could only match against ^$ regex.
                if ( isset( $rewrite['$'] ) ) {
                    $WP->matched_rule = '$';
                    $query              = $rewrite['$'];
                    $matches            = array( '' );
                }
            } else {
                foreach ( (array) $rewrite as $match => $query ) {
                    // If the requested file is the anchor of the match, prepend it to the path info.
                    if ( ! empty( $requested_file ) && strpos( $match, $requested_file ) === 0 && $requested_file != $requested_path ) {
                        $request_match = $requested_file . '/' . $requested_path;
                    }

                    if ( preg_match( "#^$match#", $request_match, $matches ) ||
                        preg_match( "#^$match#", urldecode( $request_match ), $matches ) ) {

                        if ( $wp_rewrite->use_verbose_page_rules && preg_match( '/pagename=\$matches\[([0-9]+)\]/', $query, $varmatch ) ) {
                            // This is a verbose page match, let's check to be sure about it.
                            $page = get_page_by_path( $matches[ $varmatch[1] ] );

                            if ( ! $page ) {
                                continue;
                            }

                            $post_status_obj = get_post_status_object( $page->post_status );

                            if ( ! $post_status_obj->public && ! $post_status_obj->protected
                                && ! $post_status_obj->private && $post_status_obj->exclude_from_search ) {
                                continue;
                            }
                        }

                        // Got a match.
                        $WP->matched_rule = $match;
                        break;
                    }
                }
            }

            if ( isset( $WP->matched_rule ) ) {
                // Trim the query of everything up to the '?'.
                $query = preg_replace( '!^.+\?!', '', $query );

                // Substitute the substring matches into the query.
                $query = addslashes( \WP_MatchesMapRegex::apply( $query, $matches ) );

                $WP->matched_query = $query;

                // Parse the query.
                parse_str( $query, $perma_query_vars );

                // If we're processing a 404 request, clear the error var since we found something.
                if ( '404' == $error ) {
                    unset( $error, $_GET['error'] );
                }
            }

            // If req_uri is empty or if it is a request for ourself, unset error.
            if (empty($requested_path) || $requested_file == $self || strpos($_SERVER['PHP_SELF'], 'wp-admin/') !== false) {
                unset($error, $_GET['error']);

                if (isset($perma_query_vars) && strpos($_SERVER['PHP_SELF'], 'wp-admin/') !== false && (! isset( $postData['flrt_ajax_link'] )) ) {
                    unset($perma_query_vars);
                }

                $WP->did_permalink = false;
            }

        }

        /**
         * Filters the query variables whitelist before processing.
         *
         * Allows (publicly allowed) query vars to be added, removed, or changed prior
         * to executing the query. Needed to allow custom rewrite rules using your own arguments
         * to work, or any other custom query variables you want to be publicly available.
         *
         * @since 1.5.0
         *
         * @param string[] $public_query_vars The array of whitelisted query variable names.
         */

        $WP->public_query_vars = apply_filters( 'query_vars', $WP->public_query_vars );

        foreach ( get_post_types( [], 'objects' ) as $post_type => $t ) {
            if ( is_post_type_viewable( $t ) && $t->query_var ) {
                $post_type_query_vars[ $t->query_var ] = $post_type;
            }
        }

        foreach ( $WP->public_query_vars as $wpvar ) {
            if ( isset( $WP->extra_query_vars[ $wpvar ] ) ) {
                $WP->query_vars[ $wpvar ] = $WP->extra_query_vars[ $wpvar ];
            } elseif ( isset( $_GET[ $wpvar ] ) && isset( $postData[ $wpvar ] ) && $_GET[ $wpvar ] !== $postData[ $wpvar ] ) {
                wp_die( esc_html__( 'A variable mismatch has been detected.' ), esc_html__( 'Sorry, you are not allowed to view this item.' ), 400 );
            } elseif ( isset( $postData[ $wpvar ] ) ) {
                $WP->query_vars[ $wpvar ] = $postData[ $wpvar ];
            } elseif ( isset( $_GET[ $wpvar ] ) ) {
                $WP->query_vars[ $wpvar ] = $_GET[ $wpvar ];
            } elseif ( isset( $perma_query_vars[ $wpvar ] ) ) {
                $WP->query_vars[ $wpvar ] = $perma_query_vars[ $wpvar ];
            }

            if ( ! empty( $WP->query_vars[ $wpvar ] ) ) {
                if ( ! is_array( $WP->query_vars[ $wpvar ] ) ) {
                    $WP->query_vars[ $wpvar ] = (string) $WP->query_vars[ $wpvar ];
                } else {
                    foreach ( $WP->query_vars[ $wpvar ] as $vkey => $v ) {
                        if ( is_scalar( $v ) ) {
                            $WP->query_vars[ $wpvar ][ $vkey ] = (string) $v;
                        }
                    }
                }

                if ( isset( $post_type_query_vars[ $wpvar ] ) ) {
                    $WP->query_vars['post_type'] = $post_type_query_vars[ $wpvar ];
                    $WP->query_vars['name']      = $WP->query_vars[ $wpvar ];
                }
            }
        }

        // Convert urldecoded spaces back into '+'.
        foreach ( get_taxonomies( [], 'objects' ) as $taxonomy => $t ) {
            if ( $t->query_var && isset( $WP->query_vars[ $t->query_var ] ) ) {
                $WP->query_vars[ $t->query_var ] = str_replace( ' ', '+', $WP->query_vars[ $t->query_var ] );
            }
        }

        // Don't allow non-publicly queryable taxonomies to be queried from the front end.
        if ( ! is_admin() ) {
            foreach ( get_taxonomies( array( 'publicly_queryable' => false ), 'objects' ) as $taxonomy => $t ) {
                /*
                 * Disallow when set to the 'taxonomy' query var.
                 * Non-publicly queryable taxonomies cannot register custom query vars. See register_taxonomy().
                 */
                if ( isset( $WP->query_vars['taxonomy'] ) && $taxonomy === $WP->query_vars['taxonomy'] ) {
                    unset( $WP->query_vars['taxonomy'], $WP->query_vars['term'] );
                }
            }
        }

        // Limit publicly queried post_types to those that are 'publicly_queryable'.
        if ( isset( $WP->query_vars['post_type'] ) ) {
            $queryable_post_types = get_post_types( array( 'publicly_queryable' => true ) );
            if ( ! is_array( $WP->query_vars['post_type'] ) ) {
                if ( ! in_array( $WP->query_vars['post_type'], $queryable_post_types ) ) {
                    unset( $WP->query_vars['post_type'] );
                }
            } else {
                $WP->query_vars['post_type'] = array_intersect( $WP->query_vars['post_type'], $queryable_post_types );
            }
        }

        // Resolve conflicts between posts with numeric slugs and date archive queries.
        $WP->query_vars = wp_resolve_numeric_slug_conflicts( $WP->query_vars );

        foreach ( (array) $WP->private_query_vars as $var ) {
            if ( isset( $WP->extra_query_vars[ $var ] ) ) {
                $WP->query_vars[ $var ] = $WP->extra_query_vars[ $var ];
            }
        }

        if ( isset( $error ) ) {
            $WP->query_vars['error'] = $error;
        }

        /**
         * Filters the array of parsed query variables.
         *
         * @since 2.1.0
         *
         * @param array $query_vars The array of requested query variables.
         */
        $WP->query_vars = apply_filters( 'request', $WP->query_vars );

        /**
         * Fires once all query variables for the current request have been parsed.
         *
         * @since 2.1.0
         *
         * @param WP $this Current WordPress environment instance (passed by reference).
         */
        do_action_ref_array( 'parse_request', array( &$WP ) );

        return false;
    }

    private function prepareRequest(){
        global $wp_rewrite;

        $pathinfo         = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
        list( $pathinfo ) = explode( '?', $pathinfo );
        $pathinfo         = str_replace( '%', '%25', $pathinfo );

        list( $req_uri ) = explode( '?', $this->getRequestUri() );
        $home_path       = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
        $home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );

        /*
         * Trim path info from the end and the leading home path from the front.
         * For path info requests, this leaves us with the requesting filename, if any.
         * For 404 requests, this leaves us with the requested permalink.
         */
        $req_uri  = str_replace( $pathinfo, '', $req_uri );
        $req_uri  = trim( $req_uri, '/' );
        $req_uri  = preg_replace( $home_path_regex, '', $req_uri );
        $req_uri  = trim( $req_uri, '/' );
        $pathinfo = trim( $pathinfo, '/' );
        $pathinfo = preg_replace( $home_path_regex, '', $pathinfo );
        $pathinfo = trim( $pathinfo, '/' );

        // The requested permalink is in $pathinfo for path info requests and
        // $req_uri for other requests.
        if ( ! empty( $pathinfo ) && ! preg_match( '|^.*' . $wp_rewrite->index . '$|', $pathinfo ) ) {
            $requested_path = $pathinfo;
        } else {
            // If the request uri is the index, blank it out so that we don't try to match it against a rule.
            if ( $req_uri == $wp_rewrite->index ) {
                $req_uri = '';
            }
            $requested_path = $req_uri;
        }

        return $requested_path;
    }

}