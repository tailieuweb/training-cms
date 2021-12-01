<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

use FilterEverything\Filter\Shortcodes;
use FilterEverything\Filter\Pro\PluginPro;

class Plugin
{
    private $wpManager;

    public function __construct()
    {
        $this->wpManager = Container::instance()->getWpManager();
        $this->wpManager->init();
        $this->register_hooks();

        new Shortcodes();

        if( defined('FLRT_FILTERS_PRO') && FLRT_FILTERS_PRO ){
            new PluginPro();
        }

        if( is_admin() ){
            new Admin();
        }
    }

    public function register_hooks(){
        $postData = Container::instance()->getThePost();
        $getData  = Container::instance()->getTheGet();

        if( ! is_admin() ){
            add_filter( 'do_parse_request', array( $this->wpManager, 'customParseRequest' ), 10, 3 );
            add_action( 'parse_request', array( $this->wpManager, 'parseRequest' ) );
            add_action( 'pre_get_posts', array( $this->wpManager, 'addFilterQueryToWpQuery' ), 9999 );

            add_filter( 'posts_where', [ $this->wpManager, 'fixPostsWhereForSearch' ], 10, 2 );
            add_action( 'pre_get_posts', array( $this->wpManager, 'fixSearchPostType' ), 9999 );

            add_action( 'template_redirect', [ $this, 'prepareEntities' ] );

            $sorting = new Sorting();
            $sorting->registerHooks();
        }

        add_action( 'body_class', array( $this, 'bodyClass' ) );

        add_action( 'admin_print_styles', array( $this, 'includeAdminCss' ) );
        add_action( 'admin_print_scripts', array( $this, 'includeAdminJs' ) );

        // Do not include JS, if this page is admin or can't contain filters
        if( ! is_admin() ){
            add_action( 'wp_print_styles', array( $this, 'includeFrontCss' ) );
            add_action( 'wp_print_scripts', array( $this, 'includeFrontJs' ) );
            add_action( 'wp_print_styles', array( $this, 'inlineFrontCss' ) );
        }

        add_action( 'wp_footer', [$this, 'footerHtml'] );

        if( ! defined('FLRT_FILTERS_PRO') ) {
            add_action( 'wp_head', array($this, 'noIndexFilterPages'), 1 );
            add_filter( 'wpc_filter_set_default_fields', [ $this, 'addAvailableInProFields' ], 10, 2 );
            add_filter( 'wpc_pre_save_set_fields', [ $this, 'unsetAvailableInProFields' ] );
        }

        // Disable single search result redirect
        add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );

        add_action( 'save_post', [$this, 'resetTransitions'] );
        add_action( 'delete_post', [$this, 'resetTransitions'] );
        add_action( 'woocommerce_ajax_save_product_variations', [$this, 'resetTransitions'] );

        if( isset( $getData['reset_filters_cache'] ) && $getData['reset_filters_cache'] == true ){
            $this->resetTransitions();
        }
    }

    public function resetTransitions()
    {
         $em = Container::instance()->getEntityManager();
         $all_filters = $em->getGlobalConfiguredSlugs();

         if( is_array( $all_filters ) ){
             foreach ( $all_filters as $entityEname => $slug ){
                    // For terms it should be entity name
                    $parts = explode( '#', $entityEname, 2 );
                    $e_name = isset( $parts[1] ) ? $parts[1] : '';

                    $terms_transient_key    = flrt_get_terms_transient_key( $e_name );
                    $post_ids_transient_key = flrt_get_post_ids_transient_key( $slug );
                    $var_meta_transient_key = flrt_get_variations_transient_key( 'attribute_'. $e_name );

                    delete_transient( $terms_transient_key );
                    delete_transient( $post_ids_transient_key );
                    delete_transient( $var_meta_transient_key );
             }
         }

         delete_transient('wpc_posts_variations');
         delete_transient('wpc_filters_query');

         unset( $terms_transient_key, $post_ids_transient_key, $var_meta_transient_key, $all_filters, $em );
    }

    public function prepareEntities()
    {
        $wpManager  = Container::instance()->getWpManager();
        $em         = Container::instance()->getEntityManager();
        $sets       = $wpManager->getQueryVar('wpc_page_related_set_ids');

        if( $sets ){
            foreach( $sets as $set ){
                $em->prepareEntitiesToDisplay( array( $set ) );
            }
        }
    }


    public function addAvailableInProFields( $fields, $filterSet )
    {
        foreach ( $fields as $key => $attributes ){
            // Always insert regular 'old' field
            $new_fields[$key] = $attributes;

            if( $key === 'post_name' ){

                $new_fields['instead_post_name'] = array(
                    'type'          => 'Text',
                    'label'         => esc_html__('Location', 'filter-everything'),
                    'name'          => $filterSet->generateFieldName('instead_post_name'),
                    'id'            => $filterSet->generateFieldId('instead_post_name'),
                    'class'         => 'wpc-field-instead-of-location',
                    'default'       => '',
                    'readonly'      => 'readonly',
                    'placeholder'   => esc_html__('Available in PRO', 'filter-everything'),
                    'instructions'  => esc_html__('Specify page(s) where to show this Filter Set', 'filter-everything'),
                    'settings'      => true
                );

                $new_fields['instead_wp_filter_query'] = array(
                    'type'          => 'Text',
                    'label'         => esc_html__('Query', 'filter-everything'),
                    'name'          => $filterSet->generateFieldName('instead_wp_filter_query'),
                    'id'            => $filterSet->generateFieldId('instead_wp_filter_query'),
                    'class'         => 'wpc-field-instead-wp-filter-query',
                    'default'       => '',
                    'readonly'      => 'readonly',
                    'placeholder'   => esc_html__('Available in PRO', 'filter-everything'),
                    'instructions'  => esc_html__('Select WP Query, that should be filtered', 'filter-everything'),
                    'tooltip'       => esc_html__( 'The page selected in the Location field can contain multiple WP Queries associated with the desired Post type. They can be responsible for the work of widgets, posts and even nav menus. Please, try experimentally determining which WP Query is responsible for displaying the posts you want to filter.', 'filter-everything' ),
                    'settings' => true
                );

            }

            if( $key === 'show_count' ){

                $new_fields['instead_custom_posts_container'] = array(
                    'type'          => 'Text',
                    'label'         => esc_html__('CSS ID or Class of Posts Container', 'filter-everything'),
                    'name'          => $filterSet->generateFieldName('instead_custom_posts_container'),
                    'id'            => $filterSet->generateFieldId('instead_custom_posts_container'),
                    'class'         => 'wpc-field-instead-custom-posts-container',
                    'default'       => '',
                    'readonly'      => 'readonly',
                    'placeholder'   => esc_html__('Available in PRO', 'filter-everything'),
                    'instructions'  => esc_html__('Specify individual CSS selector of Posts Container for AJAX', 'filter-everything'),
                    'settings'      => true
                );

            }

        }

        return $new_fields;
    }

    public function unsetAvailableInProFields( $setFields )
    {
        unset( $setFields['instead_post_name'], $setFields['instead_custom_posts_container'] );

        return $setFields;
    }

    public function noIndexFilterPages()
    {
        if( flrt_is_filter_request() ){
            $robots['index']    = 'noindex';
            $robots['follow']   = 'nofollow';
            $content = implode(', ', $robots );
            echo sprintf('<meta name="robots" content="%s">', $content)."\r\n";
        }
    }

    public function inlineFrontCss()
    {
        if( ! $this->wpManager->getQueryVar('allowed_filter_page') ) {
            return false;
        }

        $maxHeight      = flrt_get_option('container_height');
        $color          = flrt_get_option( 'primary_color', flrt_default_theme_color() );
        $move_to_top    = flrt_get_option('try_move_to_top_sidebar');
        $wpc_mobile_width = flrt_get_mobile_width();

        // Experimental Options
        $custom_css     = flrt_get_experimental_option('custom_css');
        $use_loader     = flrt_get_experimental_option('use_loader');
        $dark_overlay   = flrt_get_experimental_option('dark_overlay');
        $styled_inputs  = flrt_get_experimental_option('styled_inputs');
        $use_select2    = flrt_get_experimental_option('select2_dropdowns');
        $contrastColor  = false;

        $css = '';

            if( $maxHeight ){
                $css .= '.wpc-filters-section:not(.wpc-filter-post_meta_num,.wpc-filter-layout-dropdown) .wpc-filter-content:not(.wpc-filter-has-hierarchy) ul.wpc-filters-ul-list{
                        max-height: '.$maxHeight.'px;
                        overflow-y: auto;
                }'."\r\n";
            }

            if( $color ){
                $contrastColor = flrt_get_contrast_color($color);
                $css .= '.ui-slider-horizontal .ui-slider-range{
                        background-color: '.$color.';
                    }
                '."\r\n";

                $css .= '.wpc-spinner:after {
                        border-top-color: '.$color.';
                    }'."\r\n";

                $css .= '.theme-Avada .wpc-filter-product_visibility .star-rating:before,
                .wpc-filter-product_visibility .star-rating span:before{
                    color: '.$color.';
                }'."\r\n";

                $css .= '.theme-twentyfourteen .widget-area input.wpc-label-input:checked+label span.wpc-filter-label-wrapper,
                .widget-area input.wpc-label-input:checked+label span.wpc-filter-label-wrapper, 
                .wpc-filters-widget-main-wrapper input.wpc-label-input:checked+label span.wpc-filter-label-wrapper{
                        background-color: '.$color.';
                }'."\r\n";

                $css .= '.widget-area input.wpc-label-input:checked+label, 
                input.wpc-label-input:checked+label{
                        border-color: '.$color.';
                }'."\r\n";

                $css .= '#secondary .wpc-filters-labels li.wpc-term-item input:checked+label a,
                #secondary .widget-area input.wpc-label-input:checked+label span.wpc-filter-label-wrapper,
                .widget-area input.wpc-label-input:checked+label span.wpc-filter-label-wrapper, 
                .wpc-filters-widget-main-wrapper input.wpc-label-input:checked+label span.wpc-filter-label-wrapper,
                .widget-area .wpc-filters-labels li.wpc-term-item input:checked+label a, 
                .wpc-filters-widget-main-wrapper .wpc-filters-labels li.wpc-term-item input:checked+label a,
                body .wpc-filters-labels li.wpc-term-item input:checked+label a,
                body#colibri .wpc-filters-labels li.wpc-term-item input:checked+label a,
                body#colibri .widget-area input.wpc-label-input:checked+label span.wpc-filter-label-wrapper{
                        color: '.$contrastColor.';
                }'."\r\n";

                $css .= '#secondary .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a,
                .widget-area .widget .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a, 
                body .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a, 
                body#colibri .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a,
                .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a{
                    /*background-color: '.$color.';
                    color: '.$contrastColor.';*/
                    border-color: '.$color.';
                }'."\r\n";

                $css .= '.widget-area .widget .wpc-filters-widget-controls-container a.wpc-filters-apply-button, 
                .widget .wpc-filters-widget-controls-container a.wpc-filters-apply-button, 
                .wpc-filters-widget-main-wrapper .wpc-filters-widget-controls-container a.wpc-filters-apply-button{
                    border-color: '.$color.';
                    background-color: '.$color.';
                    color: '.$contrastColor.';
                }'."\r\n";

                $css .= '.widget-area .widget .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a:hover, 
                .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a:hover{
                    opacity: 0.9;
                }'."\r\n";

                $css .= '.widget-area .widget .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a:active, 
                .wpc-filter-chips-list li.wpc-filter-chip:not(.wpc-chip-reset-all) a:active{
                    opacity: 0.75;
                }'."\r\n";

//                $css .= '.wpc-filter-chips-list a:hover .wpc-chip-remove-icon,
//                .widget-area .widget .wpc-filter-chips-list a:hover .wpc-chip-remove-icon{
//                    color: '.$contrastColor.';
//                }'."\r\n";

                $css .= '.star-rating span,
                .star-rating span:before{
                    color: '.$color.';
                }'."\r\n";

                $css .= 'body a.wpc-filters-open-widget:active, a.wpc-filters-open-widget:active, 
                .wpc-filters-open-widget:active{
                    border-color: '.$color.';
                    background-color: '.$color.';
                    color: '.$contrastColor.';
                }'."\r\n";

                $css .= 'a.wpc-filters-open-widget:active span.wpc-icon-line-1:after,
                a.wpc-filters-open-widget:active span.wpc-icon-line-2:after,
                a.wpc-filters-open-widget:active span.wpc-icon-line-3:after{
                    background-color: '.$color.';
                    border-color: '.$contrastColor.';
                }'."\r\n";

                $css .= 'a.wpc-filters-open-widget:active .wpc-icon-html-wrapper span{
                    background-color: '.$contrastColor.';
                }'."\r\n";

                $css .= '@media screen and (min-width: '.$wpc_mobile_width.'px) {'."\r\n";
                $css .= '.theme-twentyfourteen .widget-area input.wpc-label-input+label:hover span.wpc-filter-label-wrapper,
                    .widget-area input.wpc-label-input+label:hover span.wpc-filter-label-wrapper, 
                    .wpc-filters-widget-main-wrapper input.wpc-label-input+label:hover span.wpc-filter-label-wrapper{
                        color: '.$contrastColor.';
                        background-color: '.$color.';
                    }'."\r\n";

                $css .= '#secondary .wpc-filters-labels li.wpc-term-item input+label:hover a,
                    body .wpc-filters-labels li.wpc-term-item input+label:hover a,
                    body#colibri .wpc-filters-labels li.wpc-term-item input+label:hover a,
                    .widget-area .wpc-filters-labels li.wpc-term-item input+label:hover a, 
                    .wpc-filters-widget-main-wrapper .wpc-filters-labels li.wpc-term-item input+label:hover a{
                        color: '.$contrastColor.';
                    }'."\r\n";
                $css .= '.widget-area input.wpc-label-input+label:hover, 
                    .wpc-filters-widget-main-wrapper input.wpc-label-input+label:hover{
                        border-color: '.$color.';
                    }'."\r\n";

                $css .= '}'."\r\n";
            }
            if( $styled_inputs ){
                $styled_color   = $color ? $color : '#0570e2';
                $contrastColor  = $contrastColor ? $contrastColor : flrt_get_contrast_color($styled_color);

                $css .= '.wpc-filters-widget-main-wrapper input[type=checkbox],
                        .wpc-filters-widget-main-wrapper input[type=radio]{
                            -webkit-appearance: none;
                            -moz-appearance: none;
                            position: relative;
                            width: 20px;
                            height: 20px;
                            border: 2px solid #bdbdbd;
                            border: 2px solid #ccd0dc;
                            background: #ffffff;
                            border-radius: 5px;
                            min-width: 20px;
                        }
                        .wpc-filters-widget-main-wrapper input[type=checkbox]:after {
                            content: "";
                            opacity: 0;
                            display: block;
                            left: 5px;
                            top: 2px;
                            position: absolute;
                            width: 4px;
                            height: 8px;
                            border: 2px solid '.$styled_color.';
                            border-top: 0;
                            border-left: 0;
                            transform: rotate(45deg);
                            box-sizing: content-box;
                        }
                        .wpc-filters-widget-main-wrapper input[type=radio]:after {
                            content: "";
                            opacity: 0;
                            display: block;
                            left: 4px;
                            top: 4px;
                            position: absolute;
                            width: 8px;
                            height: 8px;
                            border-radius: 50%;
                            background: '.$styled_color.';
                            box-sizing: content-box;
                        }
                        .wpc-filters-widget-main-wrapper input[type=radio]:checked,
                        .wpc-filters-widget-main-wrapper input[type=checkbox]:checked {
                            border-color: '.$styled_color.';
                        }
                        .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=checkbox]:after,
                        .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=checkbox],
                        .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=radio]{
                            border-color: #d8d8d8;
                        }
                        .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=radio]:after{
                            background-color: #d8d8d8;
                        }
                        .wpc-filters-widget-main-wrapper input[type=radio]:checked:after,
                        .wpc-filters-widget-main-wrapper input[type=checkbox]:checked:after {
                            opacity: 1;
                        }
                        .wpc-filters-widget-main-wrapper input[type=radio] {
                            border-radius: 50%;
                        }
                        
                        @media screen and (min-width: 768px) {
                            .wpc-filters-widget-main-wrapper input[type=radio]:hover,
                            .wpc-filters-widget-main-wrapper input[type=checkbox]:hover{
                                border-color: '.$styled_color.';
                            }
                            .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=radio]:hover,
                            .wpc-filters-widget-main-wrapper .wpc-term-count-0:not(.wpc-has-not-empty-children) input[type=checkbox]:hover{
                                border-color: #c3c3c3;
                            }
                        }';
            }

            if( $use_select2 ){
                $styled_color   = $color ? $color : '#0570e2';
                $contrastColor  = $contrastColor ? $contrastColor : flrt_get_contrast_color($styled_color);

                $css .= '.wpc-sorting-form select,
                        .wpc-filter-content select{
                            padding: 2px 8px 2px 10px;
                            border-color: #ccd0dc;
                            border-radius: 3px;
                            color: inherit;
                            -webkit-appearance: none;
                        }
                        .select2-container--default .wpc-filter-everything-dropdown .select2-results__option--highlighted[aria-selected],
                        .select2-container--default .wpc-filter-everything-dropdown .select2-results__option--highlighted[data-selected]{
                            background-color: '.$styled_color.';
                            color: '.$contrastColor.';  
                        }
                        ';
                $css .= '@media screen and (max-width: '.$wpc_mobile_width.'px) {'."\r\n";
                $css .=  '.wpc-sorting-form select,
                        .wpc-filter-content select{
                            padding: 6px 12px 6px 14px;
                        }';

                $css .= '}'."\r\n";
            }

        if( $move_to_top ){
            $css .= '@media screen and (max-width: '.$wpc_mobile_width.'px) {'."\r\n";

            $css .= 'body #main,
                        body #content .col-full,
                        .woocommerce-page .content-has-sidebar,
                        .woocommerce-page .has-one-sidebar,
                        .woocommerce-page #main-sidebar-container,
                        .woocommerce-page .theme-page-wrapper,
                        .woocommerce-page #content-area,
                        .theme-jevelin.woocommerce-page .woocomerce-styling,
                        .woocommerce-page .content_wrapper,
                        .woocommerce-page #col-mask,
                        body #main-content .content-area {
                            -js-display: flex;
                            display: -webkit-box;
                            display: -webkit-flex;
                            display: -moz-box;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-orient: vertical;
                            -moz-box-orient: vertical;
                            -webkit-flex-direction: column;
                            -ms-flex-direction: column;
                            flex-direction: column;
                        }
                        body #primary,
                        .woocommerce-page .has-one-sidebar > section,
                        .woocommerce-page .theme-content,
                        .woocommerce-page #left-area,
                        .woocommerce-page #content,
                        .woocommerce-page .sections_group,
                        .woocommerce-page .content-box,
                        body #main-sidebar-container #main {
                            -webkit-box-ordinal-group: 2;
                            -moz-box-ordinal-group: 2;
                            -ms-flex-order: 2;
                            -webkit-order: 2;
                            order: 2;
                        }
                        body #secondary,
                        .woocommerce-page .has-one-sidebar > aside,
                        body aside#mk-sidebar,
                        .woocommerce-page #sidebar,
                        .woocommerce-page .sidebar,
                        body #main-sidebar-container #sidebar {
                            -webkit-box-ordinal-group: 1;
                            -moz-box-ordinal-group: 1;
                            -ms-flex-order: 1;
                            -webkit-order: 1;
                            order: 1;
                        }
                    
                        /*second method first method solve issue theme specific*/
                        .woocommerce-page:not(.single,.page) .btWithSidebar.btSidebarLeft .btContentHolder,
                        body .theme-generatepress.woocommerce #content {
                            display: table;
                        }
                        body .btContent,
                        body .theme-generatepress.woocommerce #primary {
                            display: table-footer-group;
                        }
                        body .btSidebar,
                        body .theme-generatepress.woocommerce #left-sidebar {
                            display: table-header-group;
                        }'."\r\n";
            $css .= '}'."\r\n";
            }

            if( $use_loader ){
                $css .= '@media screen and (min-width: '.$wpc_mobile_width.'px) {'."\r\n";
                $css .= 'html.is-active .wpc-spinner{
                                display: block;
                            }';
                $css .= '}'."\r\n";
            }

            if( $dark_overlay ){
                $css .= '@media screen and (min-width: '.$wpc_mobile_width.'px) {'."\r\n";
                $css .= 'html.is-active .wpc-filters-overlay{
                            opacity: .15;
                            background: #000000;
                        }';
                $css .= '}'."\r\n";
            }

            if( $custom_css ){
                $css .= $custom_css."\r\n";
            }


        $wp_upload_dir = wp_upload_dir();
        $upload_dir_baseurl = $wp_upload_dir['baseurl'];
        $upload_dir_basepath = $wp_upload_dir['basedir'];

        $cache_dir = $upload_dir_basepath . '/cache/filter-everything/';

        if ( ! file_exists( $cache_dir ) ) {
            mkdir($cache_dir, 0777, true);
            chmod($cache_dir, 0777);
        }

        $filename = md5( $css ) . '.css';

        $fileurl  = $upload_dir_baseurl .'/cache/filter-everything/' . $filename;
        $filepath = $cache_dir . $filename;

        if ( $css !== '' ) {
            if ( ! file_exists( $filepath ) ) {
                file_put_contents( $filepath, $css );
            }

            if( file_exists( $filepath ) ){
                wp_enqueue_style('wpc-filter-everything-custom', $fileurl );
            }
        }

    }

    public function bodyClass( $classes )
    {
        if( flrt_get_option('show_open_close_button') === 'on' ){
            $classes[] = 'wpc_show_open_close_button';
        }

        return $classes;
    }

    public static function activate()
    {
        if ( ! get_option('wpc_filter_settings') ) {
            $default_show_terms_in_content  = [];
            $theme_dependencies             = flrt_get_theme_dependencies();

            if( flrt_is_woocommerce() ){
                $default_show_terms_in_content = ['woocommerce_no_products_found', 'woocommerce_archive_description'];
            }

            if ( isset( $theme_dependencies['chips_hook'] ) && is_array( $theme_dependencies['chips_hook'] ) ) {
                foreach ( $theme_dependencies['chips_hook'] as $compat_chips_hook ) {
                    $default_show_terms_in_content[] = $compat_chips_hook;
                }
            }

            $defaultOptions = array(
                'primary_color'              => '#0570e2',
                'container_height'           => '350',
                'show_open_close_button'     => '',
                'show_terms_in_content'      => $default_show_terms_in_content,
                'widget_debug_messages'      => 'on'
            );

            // PRO default options
            if( defined('FLRT_FILTERS_PRO') && FLRT_FILTERS_PRO ){
                $defaultOptions['show_bottom_widget'] = '';
            }

            add_option('wpc_filter_settings', $defaultOptions );
        }

        if( ! get_option( 'wpc_filter_experimental' ) ){

            $defaultExperimentalOptions = array(
                'use_loader'        => 'on',
                'use_wait_cursor'   => 'on',
                'dark_overlay'      => 'on',
                'auto_scroll'       => '',
                'styled_inputs'     => '',
                'select2_dropdowns' => ''
            );

            add_option('wpc_filter_experimental', $defaultExperimentalOptions );
        }
    }

    /**
     * Clears all plugin data: options and posts
     */
    public static function uninstall()
    {
        $active_plugins  = [];
        $allow_to_delete = true;

        if( is_multisite() ){
            $active_plugins = get_site_option('active_sitewide_plugins');
            if( is_array( $active_plugins ) ){
                $active_plugins = array_keys( $active_plugins );
            }
        }else{
            $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
        }

        $fe_active    = [];
        $to_compare   = [
            'filter-everything-pro/filter-everything.php',
            'filter-everything/filter-everything.php'
        ];

        if( ! empty( $active_plugins ) ){
            foreach ( $active_plugins as $plugin_path ){
                if( in_array( $plugin_path, $to_compare ) ){
                    $fe_active[] = $plugin_path;
                }
            }
        }

        if( count( $fe_active ) > 0 ){
            $allow_to_delete = false;
        }

        if( $allow_to_delete ){

            delete_option('wpc_filter_settings' );
            delete_option('wpc_indexing_deep_settings' );
            delete_option('wpc_filter_permalinks' );
            delete_option('wpc_seo_rules_settings' );
            delete_option('wpc_filter_experimental' );

            $postTypes = array(
                FLRT_FILTERS_SET_POST_TYPE,
                FLRT_FILTERS_POST_TYPE
            );

            if( defined( 'FLRT_SEO_RULES_POST_TYPE' ) ){
                $postTypes[] = FLRT_SEO_RULES_POST_TYPE;
            }

            $filterPosts = new \WP_Query(
                array(
                    'posts_per_page' => -1,
                    'post_status' => array('any'),
                    'post_type' => $postTypes,
                    'fields' => 'ids',
                    'suppress_filters' => true
                )
            );

            $filterPostsIds = $filterPosts->get_posts();

            if( ! empty( $filterPostsIds ) ){
                foreach ($filterPostsIds as $post_id) {
                    wp_delete_post( $post_id, true );
                }
            }

        }
    }

    public static function switchTheme() {
        flrt_remove_option('posts_container');
        flrt_remove_option('primary_color');
    }

    public function includeAdminCss()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
        $ver    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? rand(0, 1000) : FLRT_PLUGIN_VER;
        wp_enqueue_style( 'wpc-filter-everything-admin', FLRT_PLUGIN_URL . 'assets/css/filter-everything-admin'.$suffix.'.css', ['wp-color-picker'], $ver );

        $screen = get_current_screen();
        if( property_exists( $screen, 'base' ) && $screen->base === 'widgets' ){
            wp_enqueue_style('wpc-widgets', FLRT_PLUGIN_URL . 'assets/css/wpc-widgets' . $suffix . '.css', [], $ver );
        }
    }

    public function includeAdminJs()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
        $ver    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? rand(0, 1000) : FLRT_PLUGIN_VER;
        $select2ver = '4.1.0';

        wp_register_script( 'jquery-tiptip', FLRT_PLUGIN_URL . 'assets/js/jquery-tiptip/jquery.tipTip' . $suffix . '.js', array( 'jquery' ), $ver, true );
        wp_enqueue_script('jquery-tiptip');

        wp_enqueue_script('wpc-filters-admin', FLRT_PLUGIN_URL . 'assets/js/wpc-filters-common-admin' . $suffix . '.js', array('jquery', 'jquery-ui-sortable', 'wp-color-picker'), $ver );

        $l10n = array(
            'prefixesOrderAvailableInPro' => esc_html__( 'Editing the order of URL prefixes is available in PRO version', 'filter-everything' ),
            'chipsPlaceholder' => esc_html__( 'Select or enter hooks', 'filter-everything' )
        );
        wp_localize_script( 'wpc-filters-admin', 'wpcFiltersAdminCommon', $l10n );

        $screen = get_current_screen();

        if( property_exists( $screen, 'base' ) && strpos( $screen->base, '_page_filters-settings' )  !== false ){
            // Select2
            wp_enqueue_script( 'select2', FLRT_PLUGIN_URL . "assets/js/select2/select2".$suffix.".js", array('jquery'), $select2ver );
            wp_enqueue_style('select2', FLRT_PLUGIN_URL . "assets/css/select2/select2".$suffix.".css", '', $select2ver );
        }

        if( property_exists( $screen, 'base' ) && $screen->base === 'widgets' ){
            wp_enqueue_script('wpc-widgets', FLRT_PLUGIN_URL . 'assets/js/wpc-widgets' . $suffix . '.js', array('jquery'), $ver );
            $l10n = array(
                'wpcItemNum'  => esc_html__( 'Item #', 'filter-everything')
            );
            wp_localize_script( 'wpc-widgets', 'wpcWidgets', $l10n );
        }
    }

    public function includeFrontCss()
    {
        if( ! $this->wpManager->getQueryVar('allowed_filter_page') ) {
            if( flrt_get_option( 'widget_debug_messages' ) !== 'on' ){
                return false;
            }
        }

        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
        $ver = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? rand(0, 1000) : FLRT_PLUGIN_VER;
        wp_enqueue_style('wpc-filter-everything', FLRT_PLUGIN_URL . 'assets/css/filter-everything' . $suffix . '.css', [], $ver);

    }

    public function footerHtml()
    {
        if( $this->wpManager->getQueryVar( 'allowed_filter_page' ) ){
            echo '<div class="wpc-filters-overlay"></div>'."\r\n";
        }
    }

    public function includeFrontJs()
    {
        if( ! $this->wpManager->getQueryVar('allowed_filter_page') ) {
            if( flrt_get_option( 'widget_debug_messages' ) !== 'on' ){
                return false;
            }
        }

        $showBottomWidget   = 'no';
        $ajaxEnabled        = false;
        $autoScroll         = false;
        $waitCursor         = false;
        $wpcUseSelect2      = false;
        $wpcPopupCompatMode = false;
        $autoScrollOffset   = apply_filters( 'wpc_auto_scroll_offset', 150 );
        $wpc_mobile_width   = flrt_get_mobile_width();
        $per_page           = [];
        $sets               = $this->wpManager->getQueryVar('wpc_page_related_set_ids', []);

        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
        $ver    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? rand(0, 1000) : FLRT_PLUGIN_VER;

        if( flrt_get_option('show_bottom_widget') === 'on' ) {
            $showBottomWidget = 'yes';
        }

        if( flrt_get_option('enable_ajax') === 'on' ){
            $ajaxEnabled = true;
        }

        if( flrt_get_experimental_option('auto_scroll') === 'on' ){
            $autoScroll = true;
        }

        if( flrt_get_experimental_option( 'use_wait_cursor' ) === 'on' ){
            $waitCursor = true;
        }

        if( flrt_get_option('bottom_widget_compatibility') ){
            $wpcPopupCompatMode = true;
        }

        //@todo This appears on login page and produce not an array error
        foreach( $sets as $set ){
            if( $set['filtered_post_type'] === 'product' && function_exists('wc_get_default_products_per_row') ){
                $numberposts = apply_filters( 'loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page() );
            }else{
                $numberposts = get_option( 'posts_per_page' );
            }

            $per_page[ $set['ID'] ] = intval($numberposts);
        }

        $per_page = apply_filters( 'wpc_filter_sets_posts_per_page', $per_page );

        $wpcPostContainers = apply_filters( 'wpc_posts_containers', flrt_get_option( 'posts_container', flrt_default_posts_container() ) );

        wp_register_script( 'wc-jquery-ui-touchpunch', FLRT_PLUGIN_URL . 'assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch'.$suffix.'.js', [], $ver, true );
        wp_enqueue_script('wpc-filter-everything', FLRT_PLUGIN_URL . 'assets/js/filter-everything'.$suffix.'.js', array('jquery', 'jquery-ui-slider', 'wc-jquery-ui-touchpunch'), $ver, true );

        if( flrt_get_experimental_option('select2_dropdowns') === 'on' ){
            $select2ver = '4.1.0';
            $wpcUseSelect2 = 'yes';
            wp_enqueue_script( 'select2', FLRT_PLUGIN_URL . "assets/js/select2/select2".$suffix.".js", array('jquery'), $select2ver );
            wp_enqueue_style('select2', FLRT_PLUGIN_URL . "assets/css/select2/select2".$suffix.".css", '', $select2ver );

        }

        wp_localize_script( 'wpc-filter-everything', 'wpcFilterFront',
            array(
                'ajaxUrl'                    => admin_url('admin-ajax.php'),
                'wpcAjaxEnabled'             => $ajaxEnabled,
                'wpcStatusCookieName'        => FLRT_STATUS_COOKIE_NAME,
                'wpcHierarchyListCookieName' => FLRT_HIERARCHY_LIST_COOKIE_NAME,
                'wpcWidgetStatusCookieName'  => FLRT_OPEN_CLOSE_BUTTON_COOKIE_NAME,
                'wpcMobileWidth'             => $wpc_mobile_width,
                'showBottomWidget'           => $showBottomWidget,
                '_nonce'                     => wp_create_nonce('wpcNonceFront'),
                'wpcPostContainers'          => $wpcPostContainers,
                'wpcAutoScroll'              => $autoScroll,
                'wpcAutoScrollOffset'        => $autoScrollOffset,
                'wpcWaitCursor'              => $waitCursor,
                'wpcPostsPerPage'            => $per_page,
                'wpcUseSelect2'              => $wpcUseSelect2,
                'wpcPopupCompatMode'         => $wpcPopupCompatMode
            )
        );
    }
}