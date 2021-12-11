<?php
/**
 * Demos
 *
 * @package EnvoThemes_Demo_Import
 * @category Core
 * @author EnvoThemes
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Start Class
if (!class_exists('EnvoThemes_Demos')) {

    class EnvoThemes_Demos {

        /**
         * Start things up
         */
        public function __construct() {

            // Return if not in admin
            if (!is_admin() || is_customize_preview()) {
                return;
            }

            // Import demos page
            if (version_compare(PHP_VERSION, '5.4', '>=')) {
                require_once( ENVO_PATH . '/includes/panel/classes/importers/class-helpers.php' );
                require_once( ENVO_PATH . '/includes/panel/classes/class-install-demos.php' );
            }

            // Start things
            add_action('admin_init', array($this, 'init'));

            // Demos scripts
            add_action('admin_enqueue_scripts', array($this, 'scripts'));

            // Allows xml uploads
            add_filter('upload_mimes', array($this, 'allow_xml_uploads'));

            // Demos popup
            add_action('admin_footer', array($this, 'popup'));
        }

        /**
         * Register the AJAX methods
         *
         * @since 1.0.0
         */
        public function init() {

            // Demos popup ajax
            add_action('wp_ajax_envo_ajax_get_demo_data', array($this, 'ajax_demo_data'));
            add_action('wp_ajax_envo_ajax_required_plugins_activate', array($this, 'ajax_required_plugins_activate'));

            // Get data to import
            add_action('wp_ajax_envo_ajax_get_import_data', array($this, 'ajax_get_import_data'));

            // Import XML file
            add_action('wp_ajax_envo_ajax_import_xml', array($this, 'ajax_import_xml'));

            // Import customizer settings
            add_action('wp_ajax_envo_ajax_import_theme_settings', array($this, 'ajax_import_theme_settings'));

            // Import widgets
            add_action('wp_ajax_envo_ajax_import_widgets', array($this, 'ajax_import_widgets'));

            // After import
            add_action('wp_ajax_envo_after_import', array($this, 'ajax_after_import'));
        }

        /**
         * Load scripts
         *
         * @since 1.4.5
         */
        public static function scripts($hook_suffix) {

            if ('appearance_page_envothemes-panel-install-demos' == $hook_suffix) {

                // CSS
                wp_enqueue_style('envo-demos-style', plugins_url('/assets/css/demos.min.css', __FILE__));

                // JS
                wp_enqueue_script('envo-demos-js', plugins_url('/assets/js/demos.min.js', __FILE__), array('jquery', 'wp-util', 'updates'), '1.0', true);

                wp_localize_script('envo-demos-js', 'envoDemos', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'demo_data_nonce' => wp_create_nonce('get-demo-data'),
                    'envo_import_data_nonce' => wp_create_nonce('envo_import_data_nonce'),
                    'content_importing_error' => esc_html__('There was a problem during the importing process resulting in the following error from your server:', 'envothemes-demo-import'),
                    'button_activating' => esc_html__('Activating', 'envothemes-demo-import') . '&hellip;',
                    'button_active' => esc_html__('Active', 'envothemes-demo-import'),
                ));
            }
            
            //wp_enqueue_style('envo-notices', plugins_url('/assets/css/notify.css', __FILE__));
        }

        /**
         * Allows xml uploads so we can import from server
         *
         * @since 1.0.0
         */
        public function allow_xml_uploads($mimes) {
            $mimes = array_merge($mimes, array(
                'xml' => 'application/xml'
            ));
            return $mimes;
        }

        /**
         * Get demos data to add them in the Demo Import and Pro Demos plugins
         *
         * @since 1.4.5
         */
        public static function get_demos_data() {
            $theme = wp_get_theme();

            // Demos url
            $url = 'http://envothemes.com/wp-content/uploads/demo-import/' . $theme->template . '/';
            
            if ('Envo Shop' == $theme->name || 'envo-shop' == $theme->template) {
                $data = array(
                    $theme->template => array(
                        'demo_name' => $theme->name,
                        'categories' => array('WooCommerce'),
                        'xml_file' => $url . 'default/default-content.xml',
                        'theme_settings' => $url . 'default/default-customizer.dat',
                        'widgets_file' => $url . 'default/default-widgets.wie',
                        'screenshot' => $url . 'default/screenshot.png',
                        'home_title' => 'Home',
                        'blog_title' => 'Blog',
                        'posts_to_show' => '6',
                        'elementor_width' => '1400',
                        'is_shop' => true,
                        'woo_image_size' => '600',
                        'woo_thumb_size' => '300',
                        'woo_crop_width' => '1',
                        'woo_crop_height' => '1',
                        'required_plugins' => array(
                            'free' => array(
                                array(
                                    'slug' => 'elementor',
                                    'init' => 'elementor/elementor.php',
                                    'name' => 'Elementor',
                                ),
                                array(
                                    'slug' => 'woocommerce',
                                    'init' => 'woocommerce/woocommerce.php',
                                    'name' => 'WooCommerce',
                                ),
                                array(
                                    'slug' => 'envo-elementor-for-woocommerce',
                                    'init' => 'envo-elementor-for-woocommerce/elementor-templates-widgets-woocommerce.php',
                                    'name' => 'Elementor Templates and Widgets for WooCommerce',
                                ),
                                array(
                                    'slug' => 'yith-woocommerce-wishlist',
                                    'init' => 'yith-woocommerce-wishlist/init.php',
                                    'name' => 'YITH WooCommerce Wishlist',
                                ),
                                array(
                                    'slug' => 'yith-woocommerce-compare',
                                    'init' => 'yith-woocommerce-compare/init.php',
                                    'name' => 'YITH WooCommerce Compare',
                                ),
                            ),
                        'premium' => array( ),
                        ),
                    ),
                );
            } elseif ('Envo Shopper' == $theme->name || 'envo-shopper' == $theme->template ||'Envo Online Store' == $theme->name || 'envo-online-store' == $theme->template || 'Envo Marketplace' == $theme->name || 'envo-marketplace' == $theme->template) {
                $data = array(
                    $theme->template => array(
                        'demo_name' => $theme->name,
                        'categories' => array('WooCommerce'),
                        'xml_file' => $url . 'default/default-content.xml',
                        'theme_settings' => $url . 'default/default-customizer.dat',
                        'widgets_file' => $url . 'default/default-widgets.wie',
                        'screenshot' => $url . 'default/screenshot.png',
                        'home_title' => 'Home',
                        'blog_title' => 'Blog',
                        'posts_to_show' => '6',
                        'elementor_width' => '1140',
                        'is_shop' => true,
                        'woo_image_size' => '600',
                        'woo_thumb_size' => '300',
                        'woo_crop_width' => '2',
                        'woo_crop_height' => '3',
                        'required_plugins' => array(
                            'free' => array(
                                array(
                                    'slug' => 'elementor',
                                    'init' => 'elementor/elementor.php',
                                    'name' => 'Elementor',
                                ),
                                array(
                                    'slug' => 'woocommerce',
                                    'init' => 'woocommerce/woocommerce.php',
                                    'name' => 'WooCommerce',
                                ),
                                array(
                                    'slug' => 'envo-elementor-for-woocommerce',
                                    'init' => 'envo-elementor-for-woocommerce/elementor-templates-widgets-woocommerce.php',
                                    'name' => 'Elementor Templates and Widgets for WooCommerce',
                                ),
                                array(
                                    'slug' => 'yith-woocommerce-wishlist',
                                    'init' => 'yith-woocommerce-wishlist/init.php',
                                    'name' => 'YITH WooCommerce Wishlist',
                                ),
                                array(
                                    'slug' => 'yith-woocommerce-compare',
                                    'init' => 'yith-woocommerce-compare/init.php',
                                    'name' => 'YITH WooCommerce Compare',
                                ),
                            ),
                        'premium' => array( ),
                        ),
                    ),
                );
            } else {
                $data = array(
                    $theme->template => array(
                        'demo_name' => $theme->name,
                        'categories' => array('WooCommerce'),
                        'xml_file' => $url . 'default/default-content.xml',
                        'theme_settings' => $url . 'default/default-customizer.dat',
                        'widgets_file' => $url . 'default/default-widgets.wie',
                        'screenshot' => $url . 'default/screenshot.png',
                        'home_title' => 'Home',
                        'blog_title' => 'Blog',
                        'posts_to_show' => '6',
                        'elementor_width' => '1140',
                        'is_shop' => true,
                        'woo_image_size' => '600',
                        'woo_thumb_size' => '300',
                        'woo_crop_width' => '1',
                        'woo_crop_height' => '1',
                        'required_plugins' => array(
                            'free' => array(
                                array(
                                    'slug' => 'elementor',
                                    'init' => 'elementor/elementor.php',
                                    'name' => 'Elementor',
                                ),
                                array(
                                    'slug' => 'woocommerce',
                                    'init' => 'woocommerce/woocommerce.php',
                                    'name' => 'WooCommerce',
                                ),
                                array(
                                    'slug' => 'envo-elementor-for-woocommerce',
                                    'init' => 'envo-elementor-for-woocommerce/elementor-templates-widgets-woocommerce.php',
                                    'name' => 'Elementor Templates and Widgets for WooCommerce',
                                ),
                            ),
                        'premium' => array( ),
                        ),
                    ),
                );
            }

            // Return
            return apply_filters('envo_demos_data', $data);
        }

        /**
         * Get the category list of all categories used in the predefined demo imports array.
         *
         * @since 1.4.5
         */
        public static function get_demo_all_categories($demo_imports) {
            $categories = array();

            foreach ($demo_imports as $item) {
                if (!empty($item['categories']) && is_array($item['categories'])) {
                    foreach ($item['categories'] as $category) {
                        $categories[sanitize_key($category)] = $category;
                    }
                }
            }

            if (empty($categories)) {
                return false;
            }

            return $categories;
        }

        /**
         * Return the concatenated string of demo import item categories.
         * These should be separated by comma and sanitized properly.
         *
         * @since 1.4.5
         */
        public static function get_demo_item_categories($item) {
            $sanitized_categories = array();

            if (isset($item['categories'])) {
                foreach ($item['categories'] as $category) {
                    $sanitized_categories[] = sanitize_key($category);
                }
            }

            if (!empty($sanitized_categories)) {
                return implode(',', $sanitized_categories);
            }

            return false;
        }

        /**
         * Demos popup
         *
         * @since 1.4.5
         */
        public static function popup() {
            global $pagenow;
            if (isset($_GET['page'])) {
                // Display on the demos pages
                if (( 'themes.php' == $pagenow && 'envothemes-panel-install-demos' == $_GET['page'])) {
                    ?>

                    <div id="envo-demo-popup-wrap">
                        <div class="envo-demo-popup-container">
                            <div class="envo-demo-popup-content-wrap">
                                <div class="envo-demo-popup-content-inner">
                                    <a href="#" class="envo-demo-popup-close">×</a>
                                    <div id="envo-demo-popup-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="envo-demo-popup-overlay"></div>
                    </div>

                    <?php
                }
            }
        }

        /**
         * Demos popup ajax.
         *
         * @since 1.4.5
         */
        public static function ajax_demo_data() {

            if (!current_user_can('manage_options') || !wp_verify_nonce($_GET['demo_data_nonce'], 'get-demo-data')) {
                die('This action was stopped for security purposes.');
            }

            // Database reset url
            if (is_plugin_active('wordpress-database-reset/wp-reset.php')) {
                $plugin_link = admin_url('tools.php?page=database-reset');
            } else {
                $plugin_link = admin_url('plugin-install.php?s=WordPress+Database+Reset&tab=search');
            }
      
            // Get all demos
            $demos = self::get_demos_data();

            // Get selected demo
            if (isset($_GET['demo_name'])) {
                $demo = sanitize_text_field( wp_unslash( $_GET['demo_name'] ));
            }

            // Get required plugins
            $plugins = $demos[$demo]['required_plugins'];

            // Get free plugins
            $free = $plugins['free'];

            // Get premium plugins
            
            $premium = isset($plugins['premium']) ? $plugins['premium'] : '' ;
            ?>

            <div id="envo-demo-plugins">

                <h2 class="title"><?php echo sprintf(esc_html__('Import the %1$s demo', 'envothemes-demo-import'), esc_attr($demos[$demo]['demo_name'])); ?></h2>

                <div class="envo-popup-text">

                    <p><?php
            echo
            sprintf(
                    esc_html__('Importing demo data allow you to quickly edit everything instead of creating content from scratch. It is recommended uploading sample data on a fresh WordPress install to prevent conflicts with your current content. You can use this plugin to reset your site if needed: %1$sWordpress Database Reset%2$s.', 'envothemes-demo-import'),
                    '<a href="' . esc_url( $plugin_link ) . '" target="_blank">',
                    '</a>'
            );
            ?></p>

                    <div class="envo-required-plugins-wrap">
                        <h3><?php esc_html_e('Required Plugins', 'envothemes-demo-import'); ?></h3>
                        <p><?php esc_html_e('For your site to look exactly like this demo, the plugins below need to be activated.', 'envothemes-demo-import'); ?></p>
                        <div class="envo-required-plugins oe-plugin-installer">
                            <?php
                            self::required_plugins($free, 'free');
                            self::required_plugins($premium, 'premium');
                            ?>
                        </div>
                    </div>

                </div>

                <a class="envo-button envo-plugins-next" href="#"><?php esc_html_e('Go to the next step', 'envothemes-demo-import'); ?></a>

            </div>

            <form method="post" id="envo-demo-import-form">

                <input id="envo_import_demo" type="hidden" name="envo_import_demo" value="<?php echo esc_attr($demo); ?>" />

                <div class="envo-demo-import-form-types">

                    <h2 class="title"><?php esc_html_e('Select what you want to import:', 'envothemes-demo-import'); ?></h2>

                    <ul class="envo-popup-text">
                        <li>
                            <label for="envo_import_xml">
                                <input id="envo_import_xml" type="checkbox" name="envo_import_xml" checked="checked" />
                                <strong><?php esc_html_e('Import XML Data', 'envothemes-demo-import'); ?></strong> (<?php esc_html_e('pages, posts, images, menus, etc...', 'envothemes-demo-import'); ?>)
                            </label>
                        </li>

                        <li>
                            <label for="envo_theme_settings">
                                <input id="envo_theme_settings" type="checkbox" name="envo_theme_settings" checked="checked" />
                                <strong><?php esc_html_e('Import Customizer Settings', 'envothemes-demo-import'); ?></strong>
                            </label>
                        </li>

                        <li>
                            <label for="envo_import_widgets">
                                <input id="envo_import_widgets" type="checkbox" name="envo_import_widgets" checked="checked" />
                                <strong><?php esc_html_e('Import Widgets', 'envothemes-demo-import'); ?></strong>
                            </label>
                        </li>
                    </ul>

                </div>

                <?php wp_nonce_field('envo_import_demo_data_nonce', 'envo_import_demo_data_nonce'); ?>
                <input type="submit" name="submit" class="envo-button envo-import" value="<?php esc_html_e('Install this demo', 'envothemes-demo-import'); ?>"  />

            </form>

            <div class="envo-loader">
                <h2 class="title"><?php esc_html_e('The import process could take some time, please be patient', 'envothemes-demo-import'); ?></h2>
                <div class="envo-import-status envo-popup-text"></div>
            </div>

            <div class="envo-last">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
                <h3><?php esc_html_e('Demo Imported!', 'envothemes-demo-import'); ?></h3>
                <a href="<?php echo esc_url(get_home_url()); ?>"" target="_blank"><?php esc_html_e('See the result', 'envothemes-demo-import'); ?></a>
            </div>

            <?php
            die();
        }

        /**
         * Required plugins.
         *
         * @since 1.4.5
         */
        public static function required_plugins($plugins, $return) {

            foreach ($plugins as $key => $plugin) {

                $api = array(
                    'slug' => isset($plugin['slug']) ? $plugin['slug'] : '',
                    'init' => isset($plugin['init']) ? $plugin['init'] : '',
                    'name' => isset($plugin['name']) ? $plugin['name'] : '',
                );

                if (!is_wp_error($api)) { // confirm error free
                    // Installed but Inactive.
                    if (file_exists(WP_PLUGIN_DIR . '/' . $plugin['init']) && is_plugin_inactive($plugin['init'])) {

                        $button_classes = 'button activate-now button-primary';
                        $button_text = esc_html__('Activate', 'envothemes-demo-import');

                        // Not Installed.
                    } elseif (!file_exists(WP_PLUGIN_DIR . '/' . $plugin['init'])) {

                        $button_classes = 'button install-now';
                        $button_text = esc_html__('Install Now', 'envothemes-demo-import');

                        // Active.
                    } else {
                        $button_classes = 'button disabled';
                        $button_text = esc_html__('Activated', 'envothemes-demo-import');
                    }
                    ?>

                    <div class="envo-plugin envo-clr envo-plugin-<?php echo esc_attr($api['slug']); ?>" data-slug="<?php echo esc_attr($api['slug']); ?>" data-init="<?php echo esc_attr($api['init']); ?>">
                        <h2><?php echo esc_html($api['name']); ?></h2>

                        <?php
                        // If premium plugins and not installed
                        if ('premium' == $return && !file_exists(WP_PLUGIN_DIR . '/' . $plugin['init'])) {
                            ?>
                            <a class="button" href="https://envothemes.com/product/<?php echo esc_attr($api['slug']); ?>/" target="_blank"><?php esc_html_e('Get This Addon', 'envothemes-demo-import'); ?></a>
                            <?php } else { ?>
                            <button class="<?php echo esc_attr($button_classes); ?>" data-init="<?php echo esc_attr($api['init']); ?>" data-slug="<?php echo esc_attr($api['slug']); ?>" data-name="<?php echo esc_attr($api['name']); ?>"><?php echo esc_html($button_text); ?></button>
                        <?php } ?>
                    </div>

                    <?php
                }
            }
        }

        /**
         * Required plugins activate
         *
         * @since 1.4.5
         */
        public function ajax_required_plugins_activate() {

            if (!current_user_can('install_plugins') || !isset($_POST['init']) || !$_POST['init']) {
                wp_send_json_error(
                        array(
                            'success' => false,
                            'message' => __('No plugin specified', 'envothemes-demo-import'),
                        )
                );
            }

            $plugin_init = ( isset($_POST['init']) ) ? esc_attr($_POST['init']) : '';
            $activate = activate_plugin($plugin_init, '', false, true);

            if (is_wp_error($activate)) {
                wp_send_json_error(
                        array(
                            'success' => false,
                            'message' => $activate->get_error_message(),
                        )
                );
            }

            wp_send_json_success(
                    array(
                        'success' => true,
                        'message' => __('Plugin Successfully Activated', 'envothemes-demo-import'),
                    )
            );
        }

        /**
         * Returns an array containing all the importable content
         *
         * @since 1.4.5
         */
        public function ajax_get_import_data() {
            if (!current_user_can('manage_options')) {
                die('This action was stopped for security purposes.');
            }
            check_ajax_referer('envo_import_data_nonce', 'security');

            echo json_encode(
                    array(
                        array(
                            'input_name' => 'envo_import_xml',
                            'action' => 'envo_ajax_import_xml',
                            'method' => 'ajax_import_xml',
                            'loader' => esc_html__('Importing XML Data', 'envothemes-demo-import')
                        ),
                        array(
                            'input_name' => 'envo_theme_settings',
                            'action' => 'envo_ajax_import_theme_settings',
                            'method' => 'ajax_import_theme_settings',
                            'loader' => esc_html__('Importing Customizer Settings', 'envothemes-demo-import')
                        ),
                        array(
                            'input_name' => 'envo_import_widgets',
                            'action' => 'envo_ajax_import_widgets',
                            'method' => 'ajax_import_widgets',
                            'loader' => esc_html__('Importing Widgets', 'envothemes-demo-import')
                        ),
                    )
            );

            die();
        }

        /**
         * Import XML file
         *
         * @since 1.4.5
         */
        public function ajax_import_xml() {
            if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['envo_import_demo_data_nonce'], 'envo_import_demo_data_nonce')) {
                die('This action was stopped for security purposes.');
            }

            // Get the selected demo
            if (isset($_POST['envo_import_demo'])) {
                $demo_type = sanitize_text_field(wp_unslash($_POST['envo_import_demo']));
            }

            // Get demos data
            $demo = EnvoThemes_Demos::get_demos_data()[$demo_type];

            // Content file
            $xml_file = isset($demo['xml_file']) ? $demo['xml_file'] : '';

            // Delete the default post and page
            $sample_page = get_page_by_path('sample-page', OBJECT, 'page');
            $hello_world_post = get_page_by_path('hello-world', OBJECT, 'post');

            if (!is_null($sample_page)) {
                wp_delete_post($sample_page->ID, true);
            }

            if (!is_null($hello_world_post)) {
                wp_delete_post($hello_world_post->ID, true);
            }

            // Import Posts, Pages, Images, Menus.
            $result = $this->process_xml($xml_file);

            if (is_wp_error($result)) {
                echo json_encode($result->errors);
            } else {
                echo 'successful import';
            }

            die();
        }

        /**
         * Import customizer settings
         *
         * @since 1.4.5
         */
        public function ajax_import_theme_settings() {
            if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['envo_import_demo_data_nonce'], 'envo_import_demo_data_nonce')) {
                die('This action was stopped for security purposes.');
            }

            // Include settings importer
            include ENVO_PATH . 'includes/panel/classes/importers/class-settings-importer.php';

            // Get the selected demo
            if (isset($_POST['envo_import_demo'])) {
                $demo_type = sanitize_text_field(wp_unslash($_POST['envo_import_demo']));
            }

            // Get demos data
            $demo = EnvoThemes_Demos::get_demos_data()[$demo_type];

            // Settings file
            $theme_settings = isset($demo['theme_settings']) ? $demo['theme_settings'] : '';

            // Import settings.
            $settings_importer = new envo_Settings_Importer();
            $result = $settings_importer->process_import_file($theme_settings);

            if (is_wp_error($result)) {
                echo json_encode($result->errors);
            } else {
                echo 'successful import';
            }

            die();
        }

        /**
         * Import widgets
         *
         * @since 1.4.5
         */
        public function ajax_import_widgets() {
            if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['envo_import_demo_data_nonce'], 'envo_import_demo_data_nonce')) {
                die('This action was stopped for security purposes.');
            }

            // Include widget importer
            include ENVO_PATH . 'includes/panel/classes/importers/class-widget-importer.php';

            // Get the selected demo
            if (isset($_POST['envo_import_demo'])) {
                $demo_type = sanitize_text_field(wp_unslash($_POST['envo_import_demo']));
            }

            // Get demos data
            $demo = EnvoThemes_Demos::get_demos_data()[$demo_type];

            // Widgets file
            $widgets_file = isset($demo['widgets_file']) ? $demo['widgets_file'] : '';

            // Import settings.
            $widgets_importer = new Envo_Widget_Importer();
            $result = $widgets_importer->process_import_file($widgets_file);

            if (is_wp_error($result)) {
                echo json_encode($result->errors);
            } else {
                echo 'successful import';
            }

            die();
        }

        /**
         * After import
         *
         * @since 1.4.5
         */
        public function ajax_after_import() {
            if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['envo_import_demo_data_nonce'], 'envo_import_demo_data_nonce')) {
                die('This action was stopped for security purposes.');
            }

            // If XML file is imported
            if ($_POST['envo_import_is_xml'] === 'true') {

                // Get the selected demo
                if (isset($_POST['envo_import_demo'])) {
                    $demo_type = sanitize_text_field(wp_unslash($_POST['envo_import_demo']));
                }

                // Get demos data
                $demo = EnvoThemes_Demos::get_demos_data()[$demo_type];

                // Elementor width setting
                $elementor_width = isset($demo['elementor_width']) ? $demo['elementor_width'] : '';

                // Reading settings
                $homepage_title = isset($demo['home_title']) ? $demo['home_title'] : 'Home';
                $blog_title = isset($demo['blog_title']) ? $demo['blog_title'] : '';

                // Posts to show on the blog page
                $posts_to_show = isset($demo['posts_to_show']) ? $demo['posts_to_show'] : '';

                // If shop demo
                $shop_demo = isset($demo['is_shop']) ? $demo['is_shop'] : false;

                // Product image size
                $image_size = isset($demo['woo_image_size']) ? $demo['woo_image_size'] : '';
                $thumbnail_size = isset($demo['woo_thumb_size']) ? $demo['woo_thumb_size'] : '';
                $crop_width = isset($demo['woo_crop_width']) ? $demo['woo_crop_width'] : '';
                $crop_height = isset($demo['woo_crop_height']) ? $demo['woo_crop_height'] : '';

                // Assign WooCommerce pages if WooCommerce Exists
                if (class_exists('WooCommerce') && true == $shop_demo) {

                    $woopages = array(
                        'woocommerce_shop_page_id' => 'Shop',
                        'woocommerce_cart_page_id' => 'Cart',
                        'woocommerce_checkout_page_id' => 'Checkout',
                        'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
                        'woocommerce_thanks_page_id' => 'Order Received',
                        'woocommerce_myaccount_page_id' => 'My Account',
                        'woocommerce_edit_address_page_id' => 'Edit My Address',
                        'woocommerce_view_order_page_id' => 'View Order',
                        'woocommerce_change_password_page_id' => 'Change Password',
                        'woocommerce_logout_page_id' => 'Logout',
                        'woocommerce_lost_password_page_id' => 'Lost Password'
                    );

                    foreach ($woopages as $woo_page_name => $woo_page_title) {

                        $woopage = get_page_by_title($woo_page_title);
                        if (isset($woopage) && $woopage->ID) {
                            update_option($woo_page_name, $woopage->ID);
                        }
                    }

                    // We no longer need to install pages
                    delete_option('_wc_needs_pages');
                    delete_transient('_wc_activation_redirect');

                    // Get products image size
                    update_option('woocommerce_single_image_width', $image_size);
                    update_option('woocommerce_thumbnail_image_width', $thumbnail_size);
                    update_option('woocommerce_thumbnail_cropping', 'custom');
                    update_option('woocommerce_thumbnail_cropping_custom_width', $crop_width);
                    update_option('woocommerce_thumbnail_cropping_custom_height', $crop_height);
                }

                // Set imported menus to registered theme locations
                $locations = get_theme_mod('nav_menu_locations');
                $menus = wp_get_nav_menus();

                if ($menus) {

                    foreach ($menus as $menu) {

                        if ($menu->name == 'Main Menu') {
                            $locations['main_menu'] = $menu->term_id;
                        }
                        if ($menu->name == 'Main Menu Right') {
                            $locations['main_menu_right'] = $menu->term_id;
                        }
                        if ($menu->name == 'Categories Menu') {
                            $locations['main_menu_cats'] = $menu->term_id;
                        }
                    }
                }

                // Set menus to locations
                set_theme_mod('nav_menu_locations', $locations);

                // Disable Elementor default settings
                //update_option( 'elementor_disable_color_schemes', 'yes' );
                //update_option( 'elementor_disable_typography_schemes', 'yes' );
                if (!empty($elementor_width)) {
                    update_option('elementor_container_width', $elementor_width);
                }

                // Assign front page and posts page (blog page).
                $home_page = get_page_by_title($homepage_title);
                $blog_page = get_page_by_title($blog_title);

                update_option('show_on_front', 'page');

                if (is_object($home_page)) {
                    update_option('page_on_front', $home_page->ID);
                }

                if (is_object($blog_page)) {
                    update_option('page_for_posts', $blog_page->ID);
                }

                // Posts to show on the blog page
                if (!empty($posts_to_show)) {
                    update_option('posts_per_page', $posts_to_show);
                }
            }

            die();
        }

        /**
         * Import XML data
         *
         * @since 1.0.0
         */
        public function process_xml($file) {

            $response = envo_Demos_Helpers::get_remote($file);

            // No sample data found
            if ($response === false) {
                return new WP_Error('xml_import_error', __('Can not retrieve sample data xml file. The server may be down at the moment please try again later. If you still have issues contact the theme developer for assistance.', 'envothemes-demo-import'));
            }

            // Write sample data content to temp xml file
            $temp_xml = ENVO_PATH . 'includes/panel/classes/importers/temp.xml';
            file_put_contents($temp_xml, $response);

            // Set temp xml to attachment url for use
            $attachment_url = $temp_xml;

            // If file exists lets import it
            if (file_exists($attachment_url)) {
                $this->import_xml($attachment_url);
            } else {
                // Import file can't be imported - we should die here since this is core for most people.
                return new WP_Error('xml_import_error', __('The xml import file could not be accessed. Please try again or contact the theme developer.', 'envothemes-demo-import'));
            }
        }

        /**
         * Import XML file
         *
         * @since 1.0.0
         */
        private function import_xml($file) {

            // Make sure importers constant is defined
            if (!defined('WP_LOAD_IMPORTERS')) {
                define('WP_LOAD_IMPORTERS', true);
            }

            // Import file location
            $import_file = ABSPATH . 'wp-admin/includes/import.php';

            // Include import file
            if (!file_exists($import_file)) {
                return;
            }

            // Include import file
            require_once( $import_file );

            // Define error var
            $importer_error = false;

            if (!class_exists('WP_Importer')) {
                $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

                if (file_exists($class_wp_importer)) {
                    require_once $class_wp_importer;
                } else {
                    $importer_error = __('Can not retrieve class-wp-importer.php', 'envothemes-demo-import');
                }
            }

            if (!class_exists('WP_Import')) {
                $class_wp_import = ENVO_PATH . 'includes/panel/classes/importers/class-wordpress-importer.php';

                if (file_exists($class_wp_import)) {
                    require_once $class_wp_import;
                } else {
                    $importer_error = __('Can not retrieve wordpress-importer.php', 'envothemes-demo-import');
                }
            }

            // Display error
            if ($importer_error) {
                return new WP_Error('xml_import_error', $importer_error);
            } else {

                // No error, lets import things...
                if (!is_file($file)) {
                    $importer_error = __('Sample data file appears corrupt or can not be accessed.', 'envothemes-demo-import');
                    return new WP_Error('xml_import_error', $importer_error);
                } else {
                    $importer = new WP_Import();
                    $importer->fetch_attachments = true;
                    $importer->import($file);

                    // Clear sample data content from temp xml file
                    $temp_xml = ENVO_PATH . 'includes/panel/classes/importers/temp.xml';
                    file_put_contents($temp_xml, '');
                }
            }
        }

    }

}
new EnvoThemes_Demos();
