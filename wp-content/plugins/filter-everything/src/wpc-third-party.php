<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

function flrt_is_woocommerce()
{
    if( class_exists('WooCommerce') ){
        return true;
    }
    return false;
}

function flrt_get_mobile_width(){
    return apply_filters( 'wpc_mobile_width', 768 );
}

/**
 * @feature for other popular themes there is possibility to add action to hook get_template_part_{$slug}
 * But it seems we need to detect what current theme is enabled
 */
if( ! function_exists('flrt_wp') ){

    function flrt_wp(){
        $theme_dependencies = flrt_get_theme_dependencies();

        if( flrt_get_option('show_bottom_widget') === 'on' ) {

            if( flrt_get_experimental_option('disable_buttons') !== 'on' ) {

                if (flrt_is_woocommerce()) {
                    add_action('woocommerce_before_shop_loop', 'flrt_filters_button', 5);
                    add_action('woocommerce_no_products_found', 'flrt_filters_button', 5);
                } else {
                    if (isset($theme_dependencies['button_hook']) && is_array($theme_dependencies['button_hook'])) {
                        foreach ($theme_dependencies['button_hook'] as $button_hook) {
                            add_action($button_hook, 'flrt_filters_button', 15);
                        }
                    }
                }
            }

        }

        // Add selected terms to the top
        $chips_hooks  = flrt_get_option('show_terms_in_content', []);

        if( $chips_hooks ){
            if( is_array( $chips_hooks ) && ! empty( $chips_hooks ) ){
                foreach ( $chips_hooks as $hook ){
                    add_action( $hook, 'flrt_add_selected_terms_above_the_top' );
                }
            }
        }
    }
}

function wpc_add_selected_terms_above_the_top(){
    _deprecated_function( __FUNCTION__, '1.0.7', 'flrt_add_selected_terms_above_the_top()' );
    flrt_add_selected_terms_above_the_top();
}

function flrt_add_selected_terms_above_the_top()
{
    flrt_show_selected_terms(true);
}

function flrt_get_theme_dependencies(){
    $current_theme = strtolower( get_template() );

    $theme_dependencies = array(
        'storefront'        => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#96588a',
            'button_hook'       => array('storefront_content_top'),
            'chips_hook'        => array('storefront_loop_before')
        ),
        'hello-elementor' => array(
            'posts_container'   => '.page-content',
            'sidebar_container' => '',
            'primary_color'     => '#CC3366',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'astra' => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#0274be',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentyeleven' => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#1982d1',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentytwelve' => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#21759b',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentyfourteen' => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#24890d',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentyfifteen'     => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary', // There are problems on mobile
            // because of sidebar is hidden on mobile until user open header menu.
            'primary_color'     => '#333333',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentysixteen'     => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#007acc',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentyseventeen'   => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#222222',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentynineteen'    => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#0073aa',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentytwenty'      => array(
            'posts_container'   => '#site-content',
            'sidebar_container' => '',
            'primary_color'     => '#cd2653',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'twentytwentyone'      => array(
            'posts_container'   => '#content',
            'sidebar_container' => '.widget-area',
            'primary_color'     => '#28303d',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'popularfx'         => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#0072b7',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'oceanwp'           => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#right-sidebar',
            'primary_color'     => '#13aff0',
            'button_hook'       => array('ocean_before_content'),
            'chips_hook'        => array('ocean_before_content')
        ),
        'kadence'           => array(
            'posts_container'   => '#main',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#3182ce',
            'button_hook'       => array('kadence_before_main_content'),
            'chips_hook'        => array('kadence_before_main_content')
        ),
        'zakra'             => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#269bd1',
            'button_hook'       => array('zakra_before_posts_the_loop'),
            'chips_hook'        => array('zakra_before_posts_the_loop')
        ),
        'neve'              => array(
            'posts_container'   => '.nv-index-posts',
            'sidebar_container' => '#secondary', // '.nv-sidebar-wrap',
            'primary_color'     => '#393939',
            'button_hook'       => array('neve_before_loop'),
            'chips_hook'        => array('neve_before_loop')
        ),
        'hestia'            => array(
            'posts_container'   => '#woo-products-wrap',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#e91e63',
            'button_hook'       => array('hestia_before_index_posts_loop'),
            'chips_hook'        => array('hestia_before_index_posts_loop')
        ),
        'colibri-wp'        => array(
            'posts_container'   => '.main-row-inner .h-col:not(.colibri-sidebar)',
            'sidebar_container' => '.colibri-sidebar',
            'primary_color'     => '#03a9f4',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'teluro'            => array(
            'posts_container'   => '.main-row-inner .h-col:not(.colibri-sidebar)',
            'sidebar_container' => '.colibri-sidebar',
            'primary_color'     => '#f26559',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'numinous'          => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#f4ab00',
            'button_hook'       => array('numinous_content'),
            'chips_hook'        => ''
        ),
        'sydney'            => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#d65050',
            'button_hook'       => array('sydney_before_content'),
            'chips_hook'        => ''
        ),
        // Commercial themes
        'avada' => array(
            'posts_container'   => '#content',
            'sidebar_container' => '#sidebar',
            'primary_color'     => '#65bc7b',
            'button_hook'       => array('avada_before_main_container'),
            'chips_hook'        => ''
        ),
        'generatepress'     => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '.sidebar',
            'primary_color'     => '#1e73be',
            'button_hook'       => array('generate_before_main_content'),
            'chips_hook'        => array('generate_before_main_content')
        ),
        'the7'              => array(
            'posts_container'   => '#content',
            'sidebar_container' => '#sidebar',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'dt-the7'           => array(
            'posts_container'   => '#content',
            'sidebar_container' => '#sidebar',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'flatsome'          => array(
            'posts_container'   => '.shop-container',
            'sidebar_container' => '#shop-sidebar',
            'primary_color'     => '#446084',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'betheme'           => array(
            'posts_container'   => '.sections_group',
            'sidebar_container' => '.sidebar',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'bridge'            => array(
            'posts_container'   => '.container .column1',
            'sidebar_container' => '',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'impreza'           => array(
            'posts_container'   => '#page-content .w-grid-list',
            'sidebar_container' => '',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'enfold'            => array(
            'posts_container'   => 'main.content',
            'sidebar_container' => '',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'porto'             => array(
            'posts_container'   => '#content',
            'sidebar_container' => '',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'genesis'             => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'divi' => array(
            'posts_container'   => '#primary',
            'sidebar_container' => '#secondary',
            'primary_color'     => '',
            'button_hook'       => '',
            'chips_hook'        => ''
        ),
        'woodmart' => array(
            'posts_container'   => '.site-content',
            'sidebar_container' => '#secondary',
            'primary_color'     => '#83b735',
            'button_hook'       => '',
            'chips_hook'        => array( 'woodmart_shop_filters_area', 'woodmart_main_loop')
        )
    );

    $theme_dependencies = apply_filters( 'wpc_theme_dependencies', $theme_dependencies );

    if( isset( $theme_dependencies[ $current_theme ] ) ){
        return $theme_dependencies[ $current_theme ];
    }

    return array(
        'posts_container'   => false,
        'sidebar_container' => false,
        'primary_color'     => false,
        'button_hook'       => array(),
        'chips_hook'        => array()
    );
}

add_action( 'wp', 'flrt_wp' );

if( ! function_exists('flrt_set_posts_container') ){
    function flrt_set_posts_container( $theme_posts_container )
    {
        $theme_dependencies = flrt_get_theme_dependencies();

        if( isset( $theme_dependencies[ 'posts_container' ] ) ){
            return $theme_dependencies[ 'posts_container' ];
        }

        return $theme_posts_container;
    }
}

function flrt_set_theme_color($color ){

    $theme_dependencies = flrt_get_theme_dependencies();

    if( $theme_dependencies['primary_color'] ){
        $color = $theme_dependencies['primary_color'];
    }

    return $color;
}

if( ! function_exists('flrt_init') ){
    function flrt_init()
    {
        // Set correct theme posts container
        add_filter('wpc_theme_posts_container', 'flrt_set_posts_container');

        // Set correct theme color
        add_filter('wpc_theme_color', 'flrt_set_theme_color');
    }
}
add_action('init', 'flrt_init');

/**
 * @todo check the problem with Elementor archive template and different posts queries
 * Different post types, custom and predefined category or custom term
 */
//add_filter( 'elementor/theme/posts_archive/query_posts/query_vars', 'flrt_fix_elementor_query_args' );
//add_filter( 'elementor/query/get_query_args/current_query', 'flrt_fix_elementor_query_args' );
function flrt_fix_elementor_query_args( $query_args ){
    $wpManager = \FilterEverything\Filter\Container::instance()->getWpManager();
    if( ! $wpManager->getQueryVar( 'allowed_filter_page' ) ){
        return $query_args;
    }

    if( isset( $query_args['taxonomy']  ) ){
        unset( $query_args['taxonomy'] );
        unset( $query_args['term'] );
    }

    return $query_args;
}

function flrt_wpml_active(){
    if( defined('WPML_PLUGIN_BASENAME') ){
        return true;
    }
    return false;
}

add_action( 'elementor/editor/before_enqueue_scripts', 'flrt_include_elementor_script' );
function flrt_include_elementor_script(){
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    $ver    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? rand(0, 1000) : FLRT_PLUGIN_VER;
    wp_enqueue_script('wpc-widgets', FLRT_PLUGIN_URL . 'assets/js/wpc-widgets' . $suffix . '.js', ['jquery', 'jquery-ui-sortable'], $ver, true );
    wp_enqueue_style('wpc-widgets', FLRT_PLUGIN_URL . 'assets/css/wpc-widgets' . $suffix . '.css', [], $ver );

    $l10n = array(
        'wpcItemNum'  => esc_html__( 'Item #', 'filter-everything')
    );
    wp_localize_script( 'wpc-widgets', 'wpcWidgets', $l10n );
}