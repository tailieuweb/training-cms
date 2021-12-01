<?php
/*
Plugin Name: Filter Everything&nbsp;— WooCoomerce Product & WordPress Filter
Plugin URI: https://filtereverything.pro
Description: Filters everything in WordPress & WooCommerce: Products, any Post types, by Any Criteria. Supports AJAX. Compatible with WPML, ACF and others popular.
Version: 1.4.5
Author: Andrii Stepasiuk
Author URI: https://filtereverything.pro/about/
Text Domain: filter-everything
Domain Path: /lang
*/

// If this file is called directly, abort.
if ( ! defined('WPINC') ) {
    wp_die();
}

if( ! class_exists( 'FlrtFilter' ) ):

    class FlrtFilter{

        public function init()
        {
            global $flrt_sets, $wpc_not_fired;

            $wpc_not_fired = true;
            $flrt_sets = [];

            $this->define( 'FLRT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            $this->define( 'FLRT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            $this->define( 'FLRT_PLUGIN_BASENAME', plugin_basename(__FILE__) );
            $this->define( 'FLRT_PLUGIN_VER', '1.4.5' );
            $this->define( 'FLRT_PLUGIN_LINK', 'https://filtereverything.pro' );
            $this->define( 'FLRT_PLUGIN_DEBUG', false );
            $this->define( 'FLRT_TEMPLATES_DIR_NAME', 'filters' );

            $this->define( 'FLRT_FILTERS_SET_POST_TYPE', 'filter-set' );
            $this->define( 'FLRT_FILTERS_POST_TYPE', 'filter-field' );
            $this->define( 'FLRT_PREFIX_SEPARATOR', '-' );
            $this->define( 'FLRT_QUERY_TERMS_SEPARATOR', ';' );
            $this->define( 'FLRT_STATUS_COOKIE_NAME', 'wpcContainersStatus' );
            $this->define( 'FLRT_HIERARCHY_LIST_COOKIE_NAME', 'wpcHierarchyListStatus' );
            $this->define( 'FLRT_OPEN_CLOSE_BUTTON_COOKIE_NAME', 'wpcWidgetStatus' );
            $this->define( 'FLRT_TRANSIENT_PERIOD_HOURS', 12 );


            require_once FLRT_PLUGIN_DIR . 'src/wpc-helpers.php';

            flrt_include('src/wpc-compat.php');
            flrt_include('src/wpc-default-hooks.php');
            flrt_include('src/wpc-third-party.php');

            flrt_include('src/Plugin.php');
            flrt_include('src/PostTypes.php');
            flrt_include('src/Settings/TabInterface.php');
            flrt_include('src/Settings/BaseSettings.php');
            flrt_include('src/Settings/TabRenderer.php');
            flrt_include('src/Settings/Container.php');

            flrt_include('src/Entities/Entity.php');

            flrt_include('src/Entities/TaxonomyEntity.php');
            flrt_include('src/Entities/PostMetaEntity.php');
            flrt_include('src/Entities/PostMetaNumEntity.php');
            flrt_include('src/Entities/AuthorEntity.php');

            // Include PRO
//            flrt_include('pro/filters-pro.php');

            flrt_include('src/Entities/DefaultEntity.php');
            flrt_include('src/Entities/EntityManager.php');

            flrt_include('src/Settings/Tabs/SettingsTab.php');
            flrt_include('src/Settings/Tabs/PermalinksTab.php');
            flrt_include('src/Settings/Tabs/ExperimentalTab.php');
            flrt_include('src/Settings/Tabs/AboutProTab.php');

            flrt_include('src/Settings/Filter.php');

            flrt_include('src/RequestParser.php');
            flrt_include('src/UrlManager.php');
            flrt_include('src/Chips.php');
            flrt_include('src/Sorting.php');

            flrt_include('src/Walkers/WalkerCheckbox.php');

            flrt_include('src/TemplateManager.php');
            flrt_include('src/WpManager.php');

            flrt_include('src/Admin/FilterSet.php');
            flrt_include('src/Admin/FilterFields.php');
            flrt_include('src/Admin/Admin.php');
            flrt_include('src/Admin/AdminHooks.php');
            flrt_include('src/Admin/MetaBoxes.php');
            flrt_include('src/Admin/Widgets/FiltersWidget.php');
            flrt_include('src/Admin/Widgets/ChipsWidget.php');
            flrt_include('src/Admin/Widgets/SortingWidget.php');
            flrt_include('src/Admin/Widgets.php');
            flrt_include('src/Admin/Shortcodes.php');
            flrt_include('src/Admin/Validator.php');

            flrt_include('src/FormFields/Input.php');
            flrt_include('src/wpc-api.php');

            $this->registerHooks();

            if( flrt_get_experimental_option( 'disable_woo_orderby' ) === 'on' ) {
                if( ! function_exists('woocommerce_catalog_ordering') ){
                    function woocommerce_catalog_ordering()
                    {
                        return false;
                    }
                }
            }
        }

        public function registerHooks()
        {
            // Convert old post_name format to new. Since v1.1.24
            add_action( 'init', [$this, 'convertSetLocations'], -1 );

            // Backward compatibility. From v1.3.2
            add_action( 'init', [$this, 'convertShowChipsInContent'], -1 );

            add_action( 'init', [ $this, 'oneTwoThreeGo' ] );

            add_action( 'init', [$this, 'loadTextdomain'], 0 );

            register_activation_hook(__FILE__, ['FilterEverything\Filter\Plugin', 'activate']);

            register_uninstall_hook(__FILE__, ['FilterEverything\Filter\Plugin', 'uninstall']);

            add_action('after_switch_theme', ['FilterEverything\Filter\Plugin', 'switchTheme'] );
        }

        public function convertShowChipsInContent()
        {
            // Backward compatibility. From v1.3.2
            $filter_settings = get_option('wpc_filter_settings');

            if (isset($filter_settings['show_terms_in_content']) && $filter_settings['show_terms_in_content'] === 'on') {
                $new_chips_hooks = [];
                $theme_dependencies = flrt_get_theme_dependencies();

                if (flrt_is_woocommerce()) {
                    $new_chips_hooks[] = 'woocommerce_no_products_found';
                    $new_chips_hooks[] = 'woocommerce_archive_description';
                }

                if (isset($theme_dependencies['chips_hook']) && is_array($theme_dependencies['chips_hook'])) {
                    foreach ($theme_dependencies['chips_hook'] as $compat_chips_hook) {
                        $new_chips_hooks[] = $compat_chips_hook;
                    }
                }

                $filter_settings['show_terms_in_content'] = $new_chips_hooks;
                update_option('wpc_filter_settings', $filter_settings);
            }
        }

        public function convertSetLocations()
        {
            if( is_admin() ) {

                global $wpdb;

                // Convert separator from ":" to "___" and from -1 to 1
                $sql   = [];
                $sql[] = "SELECT {$wpdb->posts}.ID, {$wpdb->posts}.post_name";
                $sql[] = "FROM {$wpdb->posts}";
                $sql[] = "WHERE {$wpdb->posts}.post_type = '%s'";
                $sql[] = "AND {$wpdb->posts}.post_name REGEXP '[\:]+'";
                $sql[] = "OR {$wpdb->posts}.post_name = '-1'";

                $sql = implode(" ", $sql);
                $sql = $wpdb->prepare($sql, FLRT_FILTERS_SET_POST_TYPE);

                $results = $wpdb->get_results($sql, ARRAY_A);

                if (!empty($results)) {

                    foreach ($results as $row) {
                        $update = [];

                        if (!isset($row['post_name']) || !isset($row['ID'])) {
                            continue;
                        }

                        if( $row['post_name'] == '-1' ){
                            $new_post_name = '1';
                        }else{
                            $new_post_name = str_replace(":", "___", $row['post_name']);
                        }

                        $update[] = "UPDATE {$wpdb->posts}";
                        $update[] = "SET {$wpdb->posts}.post_name = '%s'";
                        $update[] = "WHERE {$wpdb->posts}.ID = %s";

                        $updateSql = implode(" ", $update);

                        $updateSql = $wpdb->prepare($updateSql, $new_post_name, $row['ID']);

                        $wpdb->query($updateSql);
                    }
                }

            }

        }

        public function loadTextdomain()
        {
            load_plugin_textdomain( 'filter-everything', false, dirname(FLRT_PLUGIN_BASENAME) . '/lang' );
        }

        public function oneTwoThreeGo()
        {
            new \FilterEverything\Filter\Plugin();
        }

        public function define( $name, $value = true )
        {
            if( ! defined( $name ) ) {
                define( $name, $value );
            }
        }

    }

    function flrt_filter()
    {
        global $wpcFilter;

        if( ! isset( $wpcFilter ) ) {
            $wpcFilter = new FlrtFilter();
            $wpcFilter->init();
        }

        return $wpcFilter;

    }

    flrt_filter();

endif;