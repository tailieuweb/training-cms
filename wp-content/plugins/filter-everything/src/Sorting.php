<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class Sorting
{

    private $sortingOptions = [];

    private $sortingDefaults = [];

    public function __construct()
    {
        $this->sortingOptions = array(
            'default'   => esc_html__('Default (no sorting)', 'filter-everything'),
            'id'        => esc_html__('By ID', 'filter-everything'),
            'random'    => esc_html__('Random','filter-everything'),
            'author'    => esc_html_x('Author', 'sorting', 'filter-everything'),
            'title'     => esc_html_x('Title', 'sorting', 'filter-everything'),
            'slug'      => esc_html__('Name (post slug)', 'filter-everything'),
            'date'      => esc_html_x('Date', 'sorting', 'filter-everything'),
            'comments'  => esc_html_x('Number of comments', 'sorting','filter-everything')
        );

        if ( class_exists( 'WooCommerce' ) ) {
            $this->sortingOptions += array(
                'price'          => esc_html_x( 'Product price', 'sorting','filter-everything' ),
                'sales_number'   => esc_html_x( 'Product sales number', 'sorting','filter-everything' ),
                'rating'         => esc_html_x( 'Product rating', 'sorting','filter-everything' ),
                'reviews_number' => esc_html_x( 'Product reviews number', 'sorting','filter-everything' )
            );
        }

        $this->sortingOptions += array(
            'm' => esc_html_x('Meta key', 'sorting','filter-everything'),
            'n' => esc_html_x('Meta key numeric', 'sorting', 'filter-everything')
        );

        $this->sortingDefaults = array(
            'titles' => array(
                esc_html__( 'Default sorting', 'filter-everything' ),
                esc_html__( 'By title: alphabetical', 'filter-everything' ),
                esc_html__( 'By title: reverse', 'filter-everything' ),
                esc_html__( 'By date: oldest first', 'filter-everything' ),
                esc_html__( 'By date: newest first', 'filter-everything' )
            ),
            'orderbies' => array(
                'default',
                'title',
                'title',
                'date',
                'date'
            ),
            'meta_keys' => array(
                0 => '',
                1 => '',
                2 => '',
                3 => '',
                4 => ''
            ),
            'orders' => array(
                'asc',
                'asc',
                'desc',
                'asc',
                'desc'
            )
        );
    }

    public function registerHooks()
    {
        add_action( 'wpc_filtered_query_end', array( $this, 'addSortArgsToWpQuery' ) );
    }

    public function addSortArgsToWpQuery( $wp_query )
    {
        // to add posts_clauses we need to check if flrt_query_hash exists in $wp_query

        $args =  $this->getOrderbyValue();

        if( ! $wp_query->get('flrt_query_hash') ){
            return $wp_query;
        }

        if( isset( $args['orderby'] ) ){
            if( $args['orderby'] === 'default' ){
                return $wp_query;
            }

            if( $args['orderby'] !== 'price' ){
                $wp_query->set( 'orderby', $args['orderby'] );
            }

        }

        if( isset( $args['order'] ) ){
            $wp_query->set( 'order', $args['order'] );
        }

        if( isset( $args['meta_key'] ) && $args['meta_key'] ){
            $wp_query->set( 'meta_key', $args['meta_key'] );
        }

    }

    public function getSortingOptions()
    {
        return $this->sortingOptions;
    }

    public function getSortingDefaults()
    {
        return $this->sortingDefaults;
    }

    public function getOrderbyValue()
    {
        $args = [];

        // Get the query args.
        if ( isset( $_SERVER['QUERY_STRING'] ) ) {
            parse_str( wp_unslash( $_SERVER['QUERY_STRING'] ), $params );
        }

        if( ! isset( $params['ordr'] ) ){
            return $args;
        }

        $queried_orderby = $params['ordr'];

        $args = $this->extractOrderValue( $queried_orderby );

        // Convert human $_GET args to WP_Query compatible args
        // Default (no order selected) is also required
        switch ( $args['orderby'] ) {
            case 'menu_order':
            case 'default':
                $args['orderby'] = 'default';
                break;
            case 'id':
                $args['orderby'] = 'ID';
                break;
            case 'random':
                $args['orderby'] = 'rand';
                break;
            case 'comments':
                $args['orderby'] = 'comment_count';
                break;
            case 'price':
                if( flrt_is_woocommerce() ){
                    $callback = 'DESC' === $args['order'] ? 'order_by_price_desc_post_clauses' : 'order_by_price_asc_post_clauses';
                    add_filter( 'posts_clauses', [ WC()->query, $callback ] );
                }
                break;
            case 'sales_number':
                if( flrt_is_woocommerce() ) {
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'total_sales';
                    add_filter('posts_clauses', [$this, 'orderByPopularityPostClauses'], 10, 2);
                }
                break;
            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby']  = [
                    'meta_value_num' => $args['order'],
                    'ID'             => 'ASC',
                ];
                break;
            case 'reviews_number':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_wc_review_count';
                break;
            case 'slug':
                $args['orderby'] = 'name';
                break;
        }

        return $args;
    }

    public function extractOrderValue( $sorting )
    {
        $args = [
            'order'     => 'ASC',
            'orderby'   => '',
            'meta_key'  => false
        ];

        // possible $sorting values title | title-desc | mprice-desc | nprice-desc | nprice
        $first_char = strtolower( substr( $sorting, 0, 1 ) );
        // Check fo meta fields
        if( $first_char === 'm' ){
            $args['orderby'] = 'meta_value';
            $rest = mb_substr( $sorting, 1);
        }else if( $first_char === 'n' ){
            $args['orderby'] = 'meta_value_num';
            $rest = mb_substr( $sorting, 1);
        }else{
            $rest = $sorting;
        }

        $last5chars = strtolower( substr( $rest, -5 ) );
        if( $last5chars === '-desc' ){
            $args['order']  = 'DESC';
            $rest = mb_substr( $rest, 0, -5 );
        }

        if( in_array( $first_char, ['m', 'n'], true ) ){
            $args['meta_key'] = $rest;
        }else{
            $args['orderby'] = $rest;
        }

        return $args;
    }

    public function orderByPopularityPostClauses( $args, $wp_query ) {
        global $wpdb;

        if( ! $wp_query->get('flrt_query_hash') ){
            return $args;
        }

        if ( isset( $_SERVER['QUERY_STRING'] ) ) {
            parse_str( wp_unslash( $_SERVER['QUERY_STRING'] ), $params );
        }

        if( ! isset( $params['ordr'] ) ){
            return $args;
        }
        $queried_orderby = $params['ordr'];
        $queried_args = $this->extractOrderValue( $queried_orderby );

        $order = $queried_args['order'];

        $join_sql = $args['join'];
        if ( ! strstr( $join_sql, 'wc_product_meta_lookup' ) ) {
            $join_sql .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";
        }

        $args['join']    = $join_sql;
        $args['orderby'] = ' wc_product_meta_lookup.total_sales ' . $order . ', wc_product_meta_lookup.product_id ' . $order;
        return $args;
    }

    public function removeOrderingArgsFilters() {
        remove_filter( 'posts_clauses', [ $this, 'orderByPopularityPostClauses' ] );
    }

}