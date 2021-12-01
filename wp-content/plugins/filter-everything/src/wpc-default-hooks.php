<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

// Make post type name lowercase in posts found message
add_filter( 'wpc_label_singular_posts_found_msg', 'mb_strtolower' );
add_filter( 'wpc_label_plural_posts_found_msg', 'mb_strtolower' );

//add_filter( 'wpc_filter_post_meta_exists_term_name', 'flrt_ucfirst_term_slug_name' );
add_filter( 'wpc_filter_post_meta_num_term_name', 'flrt_ucfirst_term_slug_name' );
add_filter( 'wpc_filter_post_meta_term_name', 'flrt_ucfirst_term_slug_name' );
if( ! function_exists('flrt_ucfirst_term_slug_name') ) {
    function flrt_ucfirst_term_slug_name($term_name)
    {
        $term_name = flrt_ucfirst($term_name);
        return $term_name;
    }
}

add_filter( 'wpc_filter_post_meta_exists_term_name', 'flrt_custom_field_exists_name' );
if( ! function_exists( 'flrt_custom_field_exists_name' ) ){
    function flrt_custom_field_exists_name( $term_name ){
        if( $term_name === 'yes'  ){
            return esc_html__('Yes', 'filter-everything');
        }else if( $term_name === 'no' ){
            return esc_html__('No', 'filter-everything');
        }
        return $term_name;
    }
}

add_filter( 'wpc_filter_post_meta_term_name', 'flrt_stock_status_term_name', 10, 2 );
if( ! function_exists('flrt_stock_status_term_name') ) {
    function flrt_stock_status_term_name($term_name, $e_name)
    {
        if ($e_name === '_stock_status') {
            $term_name = strtolower($term_name);
            if ($term_name === "instock") {
                $term_name = esc_html__('In stock', 'filter-everything');
            }

            if ($term_name === "onbackorder") {
                $term_name = esc_html__('On backorder', 'filter-everything');
            }

            if ($term_name === "outofstock") {
                $term_name = esc_html__('Out of stock', 'filter-everything');
            }
        }

        return $term_name;
    }
}

add_filter( 'wpc_filter_post_meta_exists_term_name', 'flrt_on_sale_term_name', 15, 2 );
if( ! function_exists('flrt_on_sale_term_name') ) {
    function flrt_on_sale_term_name( $term_name, $entity )
    {
        if( $entity === '_sale_price' ){
            $term_name = strtolower( $term_name );
            if( $term_name === 'yes' ){
                $term_name = esc_html__('On Sale', 'filter-everything');
            }
            if( $term_name  === 'no' ){
                $term_name = esc_html__('Regular price', 'filter-everything');
            }
        }
        return $term_name;
    }
}

add_filter('wpc_filter_taxonomy_term_name', 'flrt_modify_taxonomy_term_name', 10, 2 );
if( ! function_exists( 'flrt_modify_taxonomy_term_name' ) ) {
    function flrt_modify_taxonomy_term_name($term_name, $e_name)
    {
        if (in_array($e_name, array('product_type', 'product_visibility'))) {
            $term_name = flrt_ucfirst($term_name);
        }
        return $term_name;
    }
}

add_filter('wpc_filter_term_query_args', 'flrt_exclude_uncategorized_category', 10, 3);
if( ! function_exists('flrt_exclude_uncategorized_category') ) {
    function flrt_exclude_uncategorized_category($args, $entity, $e_name)
    {
        if ($e_name === 'category') {
            $args['exclude'] = array(1); // Uncategorized category
        }

        return $args;
    }
}

add_filter( 'wpc_filter_get_taxonomy_terms', 'flrt_exclude_product_visibility_terms', 10, 2 );
if( ! function_exists('flrt_exclude_product_visibility_terms') ) {
    function flrt_exclude_product_visibility_terms( $terms, $e_name )
    {
        if( $e_name === 'product_visibility' ){
            if( is_array( $terms ) ){
                foreach ( $terms as $index => $term ){

                    if( in_array( $term->slug, array( 'exclude-from-search', 'exclude-from-catalog' ) ) ){
                        unset( $terms[$index] );
                    }
                }
            }
        }

        if( $e_name === 'product_cat' ){
            if( is_array( $terms ) ){
                foreach ( $terms as $index => $term ){
                    if( in_array( $term->slug, array( 'uncategorized' ) ) ){
                        unset( $terms[$index] );
                    }
                }
            }
        }

        return $terms;
    }
}

add_filter( 'wpc_filter_author_query_post_types', 'flrt_remove_author_query_post_types' );
if( ! function_exists('flrt_remove_author_query_post_types') ) {
    function flrt_remove_author_query_post_types( $post_types )
    {
        if( isset( $post_types['attachment'] ) ){
            unset( $post_types['attachment'] );
        }
        return $post_types;
    }
}

function flrt_chips( $showReset = false, $setIds = [] ) {
    $templateManager    = \FilterEverything\Filter\Container::instance()->getTemplateManager();
    $wpManager          = \FilterEverything\Filter\Container::instance()->getWpManager();

    if( ! $wpManager->getQueryVar( 'allowed_filter_page' ) ){
        return false;
    }

    if( empty( $setIds ) || ! $setIds || ! is_array( $setIds ) ){
        foreach ( $wpManager->getQueryVar('wpc_page_related_set_ids') as $set ){
            $setIds[] = $set['ID'];
        }
    }

    $chipsObj = new \FilterEverything\Filter\Chips( $showReset, $setIds );
    $chips = $chipsObj->getChips();

    $templateManager->includeFrontView( 'chips', array( 'chips' => $chips, 'setid' => reset($setIds) ) );

}

function flrt_show_selected_terms( $showReset = true, $setIds = [], $class = [] )
{
    $default_class  = array('wpc-custom-selected-terms');

    if(! empty( $class ) && is_array($class) ){
        $default_class = array_merge( $default_class, $class );
    }

    echo '<div class="'.implode(' ', $default_class).'">'."\r\n";
        flrt_chips( $showReset, $setIds );
    echo '</div>'."\r\n";
}

add_filter( 'wpc_dropdown_option_attr', 'flrt_parse_dropdown_value' );
function flrt_parse_dropdown_value( $attr ){
    if( ! is_array( $attr ) ){
        $new_attr = array();
        $new_attr['label'] = $attr;
        return $new_attr;
    }

    return $attr;
}

add_filter( 'wpc_unnecessary_get_parameters', 'flrt_unnecessary_get_parameters' );
function flrt_unnecessary_get_parameters( $params ){
    $unnecessary_params = array(
        'product-page' => true,
        '_pjax' => true
    );

    return array_merge( $params, $unnecessary_params );
}

add_filter('wpc_posts_containers', 'flrt_convert_posts_container_to_array');
function flrt_convert_posts_container_to_array( $container ){

    if( ! is_array( $container ) ){
        return [ 'default' => trim($container) ];
    }

    return $container;
}

add_filter( 'wpc_filter_post_types', 'flrt_exclude_post_types' );
if( ! function_exists('flrt_exclude_post_types') ) {
    function flrt_exclude_post_types($post_types)
    {

        $post_types = array(
            FLRT_FILTERS_POST_TYPE,
            FLRT_FILTERS_SET_POST_TYPE,
            'attachment',
            'elementor_library',
            'e-landing-page',
            'jet-smart-filters',
            'ct_template'
        );

        return $post_types;
    }
}

add_action('wpc_after_filter_input', 'flrt_after_filter_input');
if( ! function_exists('flrt_after_filter_input') ) {
    function flrt_after_filter_input($attributes)
    {
        if( isset($attributes['class']) && $attributes['class'] === 'wpc-field-slug' && $attributes['value'] === '' ){
            echo '<p class="description">'.esc_html__( 'a-z, 0-9, "_" and "-" symbols supported only', 'filter-everything').'</p>';
        }

        if( isset($attributes['class']) && $attributes['class'] === 'wpc-field-ename' && $attributes['value'] === '' ){
            echo '<p class="description">'.esc_html__( 'Note: for ACF meta fields, please use names without the "_" character at the beginning', 'filter-everything').'</p>';
        }

    }
}