<?php
/**
 * Theme Wizard
 *
 * @package EnvoThemes_Demo_Import
 * @category Core
 * @author EnvoThemes
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('EnvoThemes_Demo_Import_Theme_Wizard')):

    // Start Class
    class EnvoThemes_Demo_Import_Theme_Wizard {

        /**
         * Current step
         *
         * @var string
         */
        private $step = '';

        /**
         * Steps for the setup wizard
         *
         * @var array
         */
        private $steps = array();

        public function __construct() {
            $this->includes();
            add_action('admin_menu', array($this, 'add_envo_wizard_menu'));
            add_action('admin_init', array($this, 'envo_wizard_setup'), 99);
            add_action('wp_loaded', array($this, 'remove_notice'));
            add_action('admin_print_styles', array($this, 'add_notice'));
            add_action("add_second_notice", array($this, "install"));
        }

        public static function install() {
            if (!get_option("envo_wizard")) {
                update_option("envo_wizard", "un-setup");
                (wp_safe_redirect(admin_url('admin.php?page=envo_setup')));
            } else {
                // first run for automatic message after first 24 hour
                if (!get_option("automatic_2nd_notice")) {
                    update_option("automatic_2nd_notice", "second-time");
                } else {
                    // clear cronjob after second 24 hour
                    wp_clear_scheduled_hook('add_second_notice');
                    delete_option("automatic_2nd_notice");
                    delete_option("2nd_notice");
                    delete_option("envo_wizard");
                    wp_safe_redirect(admin_url());
                    exit;
                }
            }
        }

        // clear cronjob when deactivate plugin
        public static function uninstall() {
            wp_clear_scheduled_hook('add_second_notice');
            delete_option("automatic_2nd_notice");
            delete_option("2nd_notice");
            delete_option("envo_wizard");
        }

        public function remove_notice() {
            if (isset($_GET['envo_wizard_hide_notice']) && $_GET['envo_wizard_hide_notice'] == "install") { // WPCS: input var ok, CSRF ok.
                // when finish install
                delete_option("envo_wizard");
                //clear cronjob when finish install
                wp_clear_scheduled_hook('add_second_notice');
                delete_option("2nd_notice");
                if (isset($_GET['show'])) {
                    wp_safe_redirect(home_url());
                    exit;
                }
            } else if (isset($_GET['envo_wizard_hide_notice']) && $_GET['envo_wizard_hide_notice'] == "2nd_notice") { // WPCS: input var ok, CSRF ok.
                //when skip install
                delete_option("envo_wizard");
                if (!get_option("2nd_notice")) {
                    update_option("2nd_notice", "second-time");
                    date_default_timezone_set(get_option('timezone_string'));
                    // set time for next day
                    $new_time_format = time() + (24 * 60 * 60 );
                    //add "add_second_notice" cronjob
                    if (!wp_next_scheduled('add_second_notice')) {
                        wp_schedule_event($new_time_format, 'daily', 'add_second_notice');
                    }
                } else {
                    //clear cronjob when skip for second time
                    wp_clear_scheduled_hook('add_second_notice');
                }
                if (isset($_GET['show'])) {
                    wp_safe_redirect(home_url());
                    exit;
                } else {
                    wp_safe_redirect(admin_url());
                    exit;
                }
            }
        }

        public function add_notice() {
            if ((get_option("envo_wizard") == "un-setup") && (empty($_GET['page']) || 'envo_setup' !== $_GET['page'])) {
                if (!get_option("2nd_notice") && !get_option("automatic_2nd_notice")) {
                    ?>
                    <div class="updated notice-success envo-extra-notice">
                        <div class="notice-inner">
                            <div class="notice-content">
                                <p><?php esc_html_e('Are you ready to create an amazing website?', 'envothemes-demo-import'); ?></p>
                                <p class="submit">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=envo_setup')); ?>" class="btn button-primary"><?php esc_html_e('Run the Setup Wizard', 'envothemes-demo-import'); ?></a>
                                    <a class="btn button-secondary" href="<?php echo esc_url((add_query_arg('envo_wizard_hide_notice', '2nd_notice'))); ?>"><?php esc_html_e('Skip setup', 'envothemes-demo-import'); ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

        private function includes() {
            require_once( ENVO_PATH . '/includes/wizard/classes/QuietSkin.php' );
            require_once( ENVO_PATH . '/includes/wizard/classes/WizardAjax.php' );
        }

        public function add_envo_wizard_menu() {
            add_dashboard_page('', '', 'manage_options', 'envo_setup', '');
        }

        public function envo_wizard_setup() {
            if (!current_user_can('manage_options'))
                return;
            if (empty($_GET['page']) || 'envo_setup' !== $_GET['page']) { // WPCS: CSRF ok, input var ok.
                return;
            }
            $default_steps = array(
                'welcome' => array(
                    'name' => __('Welcome', 'envothemes-demo-import'),
                    'view' => array($this, 'envo_welcome'),
                ),
                'demo' => array(
                    'name' => __('Choosing Demo', 'envothemes-demo-import'),
                    'view' => array($this, 'envo_demo_setup'),
                ),
                'customize' => array(
                    'name' => __('Customize', 'envothemes-demo-import'),
                    'view' => array($this, 'envo_customize_setup'),
                ),
                'ready' => array(
                    'name' => __('Ready', 'envothemes-demo-import'),
                    'view' => array($this, 'envo_ready_setup'),
                )
            );
            $this->steps = apply_filters('envo_setup_wizard_steps', $default_steps);
            $this->step = isset($_GET['step']) ? sanitize_key($_GET['step']) : current(array_keys($this->steps)); // WPCS: CSRF ok, input var ok.
            // CSS
            wp_enqueue_style('envo-wizard-style', plugins_url('/assets/css/style.min.css', __FILE__));

            // RTL
            if (is_RTL()) {
                wp_enqueue_style('envo-wizard-rtl', plugins_url('/assets/css/rtl.min.css', __FILE__));
            }

            // JS
            wp_enqueue_script('envo-wizard-js', plugins_url('/assets/js/wizard.min.js', __FILE__), array('jquery', 'wp-util', 'updates'));

            wp_localize_script('envo-wizard-js', 'envoDemos', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'demo_data_nonce' => wp_create_nonce('get-demo-data'),
                'envo_import_data_nonce' => wp_create_nonce('envo_import_data_nonce'),
                'content_importing_error' => esc_html__('There was a problem during the importing process resulting in the following error from your server:', 'envothemes-demo-import'),
                'button_activating' => esc_html__('Activating', 'envothemes-demo-import') . '&hellip;',
                'button_active' => esc_html__('Active', 'envothemes-demo-import'),
            ));

            global $current_screen, $hook_suffix, $wp_locale;
            if (empty($current_screen))
                set_current_screen();
            $admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);

            ob_start();
            ?>
            <!DOCTYPE html>
            <html <?php language_attributes(); ?>>
                <head>
                    <meta name="viewport" content="width=device-width" />
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title><?php esc_html_e('EnvoThemes &rsaquo; Setup Wizard', 'envothemes-demo-import'); ?></title>
                    <script type="text/javascript">
                        addLoadEvent = function (func) {
                            if (typeof jQuery != "undefined")
                                jQuery(document).ready(func);
                            else if (typeof wpOnload != 'function') {
                                wpOnload = func;
                            } else {
                                var oldonload = wpOnload;
                                wpOnload = function () {
                                    oldonload();
                                    func();
                                }
                            }
                        };
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>',
                                pagenow = '<?php echo $current_screen->id; ?>',
                                typenow = '<?php echo $current_screen->post_type; ?>',
                                adminpage = '<?php echo $admin_body_class; ?>',
                                thousandsSeparator = '<?php echo addslashes($wp_locale->number_format['thousands_sep']); ?>',
                                decimalPoint = '<?php echo addslashes($wp_locale->number_format['decimal_point']); ?>',
                                isRtl = <?php echo (int) is_rtl(); ?>;
                    </script>
                    <?php
                    //include demos script
                    wp_print_scripts('envo-wizard-js');

                    //include custom scripts in specifiec steps
                    if ($this->step == 'demo' || $this->step == "welcome" || $this->step == 'customize') {
                        wp_print_styles('themes');
                        wp_print_styles('buttons');
                        wp_print_styles('dashboard');
                        wp_print_styles('common');
                    }

                    if ($this->step == 'customize') {
                        wp_print_styles('media');
                        wp_enqueue_media();
                        wp_enqueue_style('wp-color-picker');
                        wp_enqueue_script('wp-color-picker');
                    }

                    //add admin styles
                    do_action('admin_print_styles');

                    do_action('admin_head');
                    ?>
                </head>
                <body class="envo-setup wp-core-ui">
                    <?php $logo = '<a href="https://envothemes.com/?utm_source=dash&utm_medium=wizard&utm_campaign=logo">EnvoThemes</a>'; ?>
                    <div id="envo-logo"><?php echo $logo; ?></div>
                    <?php
                    $this->setup_wizard_steps();
                    $this->setup_wizard_content();
                    _wp_footer_scripts();
                    do_action('admin_footer');
                    ?>
                </body>
            </html>
            <?php
            exit;
        }

        /**
         * Output the steps.
         */
        public function setup_wizard_steps() {
            $output_steps = $this->steps;
            ?>
            <ol class="envo-setup-steps">
                <?php
                foreach ($output_steps as $step_key => $step) {
                    $is_completed = array_search($this->step, array_keys($this->steps), true) > array_search($step_key, array_keys($this->steps), true);

                    if ($step_key === $this->step) {
                        ?>
                        <li class="active"><?php echo esc_html($step['name']); ?></li>
                        <?php
                    } elseif ($is_completed) {
                        ?>
                        <li class="done">
                            <a href="<?php echo esc_url(add_query_arg('step', $step_key, remove_query_arg('activate_error'))); ?>"><?php echo esc_html($step['name']); ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li><?php echo esc_html($step['name']); ?></li>
                        <?php
                    }
                }
                ?>
            </ol>
            <?php
        }

        /**
         * Output the content for the current step.
         */
        public function setup_wizard_content() {
            echo '<div class="envo-setup-content">';
            if (!empty($this->steps[$this->step]['view'])) {
                call_user_func($this->steps[$this->step]['view'], $this);
            }
            echo '</div>';
        }

        /**
         * Get Next Step
         * @param type $step
         * @return string
         */
        public function get_next_step_link($step = '') {
            if (!$step) {
                $step = $this->step;
            }

            $keys = array_keys($this->steps);
            if (end($keys) === $step) {
                return admin_url();
            }

            $step_index = array_search($step, $keys, true);
            if (false === $step_index) {
                return '';
            }

            return add_query_arg('step', $keys[$step_index + 1], remove_query_arg('activate_error'));
        }

        /**
         * Get Previous Step
         * @param type $step
         * @return string
         */
        public function get_previous_step_link($step = '') {

            if (!$step) {
                $step = $this->step;
            }

            $keys = array_keys($this->steps);

            $step_index = array_search($step, $keys, true);

            if (false === $step_index) {
                return '';
            }
            $url = FALSE;

            if (isset($keys[$step_index - 1])) {
                $url = add_query_arg('step', $keys[$step_index - 1], remove_query_arg('activate_error'));
            }
            return $url;
        }

        /**
         * Helper method to retrieve the current user's email address.
         *
         * @return string Email address
         */
        protected function get_current_user_email() {
            $current_user = wp_get_current_user();
            $user_email = $current_user->user_email;

            return $user_email;
        }

        /**
         * Step 1 Welcome
         */
        public function envo_welcome() {
            // Image
            $img = plugins_url('/assets/img/start.png', __FILE__);

            // Button icon
            if (is_RTL()) {
                $icon = 'left';
            } else {
                $icon = 'right';
            }
            ?>

            <div class="envo-welcome-wrap envo-wrap">
                <h2><?php esc_attr_e("Setup Wizard", 'envothemes-demo-import'); ?></h2>
                <h1><?php esc_attr_e("Welcome!", 'envothemes-demo-import'); ?></h1>
                <div class="envo-thumb">
                    <img src="<?php echo esc_url($img); ?>" width="425" height="290" />
                </div>
                <p><?php esc_attr_e("Thank you for choosing EnvoThemes theme, in this quick setup wizard we'll take you through the 2 essential steps for you to get started building your dream website. Make sure to go through it to the end.", 'envothemes-demo-import'); ?></p>
                <div class="envo-wizard-setup-actions">
                    <a class="skip-btn continue" href="<?php echo $this->get_next_step_link(); ?>"><?php esc_attr_e("Get started", 'envothemes-demo-import'); ?><i class="dashicons dashicons-arrow-<?php echo esc_attr($icon); ?>-alt"></i></a>
                </div>
                <a class="envo-setup-footer-links" href="<?php echo esc_url(( add_query_arg(array('envo_wizard_hide_notice' => '2nd_notice'), admin_url()))); ?>"><?php esc_attr_e("Skip Setup Wizard", 'envothemes-demo-import'); ?></a>
            </div>
            <?php
        }

        /**
         * Step 2 list demo
         */
        public function envo_demo_setup() {
            $demos = EnvoThemes_Demos::get_demos_data();

            // Button icon
            if (is_RTL()) {
                $icon = 'left';
            } else {
                $icon = 'right';
            }
            ?>

            <div class="envo-demos-wrap envo-wrap">
                <div class="demo-import-loader preview-all"></div>
                <div class="demo-import-loader preview-icon"><i class="custom-loader"></i></div>

                <div class="envo-demo-wrap">
                    <h1><?php esc_attr_e("Selecting your demo template", 'envothemes-demo-import'); ?></h1>
                    <p><?php
                        echo
                        sprintf(__('Clicking %1$sLive Preview%2$s will open the demo in a new window for you to decide which template to use. Then %1$sSelect%2$s the demo you want and click %1$sInstall Demo%2$s in the bottom.', 'envothemes-demo-import'), '<strong>', '</strong>'
                        );
                        ?></p>
                    <div class="theme-browser rendered">

                        <?php $categories = EnvoThemes_Demos::get_demo_all_categories($demos); ?>

                        <?php if (!empty($categories)) : ?>
                            <div class="envo-header-bar">
                                <nav class="envo-navigation">
                                    <ul>
                                        <li class="active"><a href="#all" class="envo-navigation-link"><?php esc_html_e('All', 'envothemes-demo-import'); ?></a></li>
                                        <?php foreach ($categories as $key => $name) : ?>
                                            <li><a href="#<?php echo esc_attr($key); ?>" class="envo-navigation-link"><?php echo esc_html($name); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </nav>

                            </div>
                        <?php endif; ?>

                        <div class="themes wp-clearfix">

                            <?php
                            // Loop through all demos
                            foreach ($demos as $demo => $key) {

                                // Vars
                                $item_categories = EnvoThemes_Demos::get_demo_item_categories($key);
                                ?>

                                <div class="theme-wrap" data-categories="<?php echo esc_attr($item_categories); ?>" data-name="<?php echo esc_attr(strtolower($demo)); ?>">

                                    <div class="theme envo-open-popup" data-demo-id="<?php echo esc_attr($demo); ?>">

                                        <div class="theme-screenshot">
                                            <img src="<?php echo esc_url($key['screenshot']); ?>" />

                                        </div>

                                        <div class="theme-id-container">

                                            <h2 class="theme-name" id="<?php echo esc_attr($demo); ?>"><span><?php echo esc_html($key['demo_name']); ?></span></h2>
                                            <div class="theme-actions">
                                                <a class="button button-primary" href="https://envothemes.com/<?php echo esc_attr($demo); ?>" target="_blank"><?php esc_html_e('Live Preview', 'envothemes-demo-import'); ?></a>
                                                <span class="button button-secondary"><?php esc_html_e('Select', 'envothemes-demo-import'); ?></span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            <?php } ?>

                        </div>
                        <div class="envo-wizard-setup-actions">
                            <button class="install-demos-button disabled" disabled data-next_step="<?php echo $this->get_next_step_link(); ?>"><?php esc_html_e("Install Demo", 'envothemes-demo-import'); ?></button>
                            <a class="skip-btn" href="<?php echo $this->get_next_step_link(); ?>"><?php esc_html_e("Skip Step", 'envothemes-demo-import'); ?></a>
                        </div>                
                    </div>

                </div>

                <div class="envo-wizard-setup-actions wizard-install-demos-buttons-wrapper final-step">
                    <a class="skip-btn continue" href="<?php echo $this->get_next_step_link(); ?>"><?php esc_html_e("Next Step", 'envothemes-demo-import'); ?><i class="dashicons dashicons-arrow-<?php echo esc_attr($icon); ?>-alt"></i></a>
                </div>
            </div>
            <?php
        }

        /**
         * Step 3 customize step
         */
        public function envo_customize_setup() {

            if (isset($_POST['save_step']) && !empty($_POST['save_step'])) {
                $this->save_envo_customize();
            }

            // Button icon
            if (is_RTL()) {
                $icon = 'left';
            } else {
                $icon = 'right';
            }
            ?>

            <div class="envo-customize-wrap envo-wrap">
                <form method="POST" name="envo-customize-form">
                    <?php wp_nonce_field('envo_customize_form'); ?>
                    <div class="field-group">
                        <?php
                        $custom_logo = get_theme_mod("custom_logo");
                        $display = "none";
                        $url = "";

                        if ($custom_logo) {
                            $display = "inline-block";
                            if (!($url = wp_get_attachment_image_url($custom_logo))) {
                                $custom_logo = "";
                                $display = "none";
                            }
                        }
                        ?>
                        <h1><?php esc_html_e("Logo", 'envothemes-demo-import'); ?></h1>
                        <p><?php esc_html_e("Please add your logo below.", 'envothemes-demo-import'); ?></p>
                        <div class="upload">
                            <img  src="<?php echo $url; ?>"  width="115px" height="115px" id="envo-logo-img" style="display:<?php echo $display; ?>;"/>
                            <div>
                                <input type="hidden" name="envo-logo" id="envo-logo" value="<?php echo $custom_logo; ?>" />
                                <button type="submit" data-name="envo-logo" class="upload_image_button button"><?php esc_html_e("Upload", 'envothemes-demo-import'); ?></button>
                                <button  style="display:<?php echo $display; ?>;" type="submit" data-name="envo-logo" class="remove_image_button button">&times;</button>
                            </div>
                        </div>

                    </div>

                    <div class="field-group">
                        <h1><?php esc_html_e("Site Title", 'envothemes-demo-import'); ?></h1>
                        <p><?php esc_html_e("Please add your Site Title below.", 'envothemes-demo-import'); ?></p>
                        <input type="text" name="envo-site-title" id="envo-site-title" class="envo-input" value="<?php echo get_option("blogname"); ?>">
                    </div>

                    <div class="field-group">
                        <h1><?php esc_html_e("Tagline", 'envothemes-demo-import'); ?></h1>
                        <p><?php esc_html_e("Please add your Tagline below.", 'envothemes-demo-import'); ?></p>
                        <input type="text" name="envo-tagline" id="envo-tagline" class="envo-input" value="<?php echo get_option("blogdescription"); ?>">
                    </div>

                    <div class="field-group">

                        <?php
                        $favicon = get_option("site_icon");
                        $display = "none";
                        $url = "";

                        if ($favicon) {
                            $display = "inline-block";
                            $url = wp_get_attachment_image_url($favicon);
                            if (!($url = wp_get_attachment_image_url($favicon))) {
                                $favicon = "";
                                $display = "none";
                            }
                        }
                        ?>
                        <h1><?php esc_html_e("Site Icon", 'envothemes-demo-import'); ?></h1>
                        <p><?php esc_html_e("Site Icons are what you see in browser tabs, bookmark bars, and within the WordPress mobile apps. Upload one here! Site Icons should be square and at least 512 × 512 pixels.", 'envothemes-demo-import'); ?></p>
                        <div class="upload">
                            <img src="<?php echo $url; ?>" width="115px" height="115px" id="envo-favicon-img" style="display:<?php echo $display; ?>;"/>
                            <div>
                                <input type="hidden" name="envo-favicon" id="envo-favicon" value="<?php echo $favicon; ?>" />
                                <button type="submit" data-name="envo-favicon" class="upload_image_button button"><?php esc_attr_e("Upload", 'envothemes-demo-import'); ?></button>
                                <button  style="display:<?php echo $display; ?>;" type="submit" data-name="envo-favicon" class="remove_image_button button">&times;</button>
                            </div>
                        </div>

                    </div>

                    <div class="envo-wizard-setup-actions">
                        <input type="hidden" name="save_step" value="save_step"/>
                        <button class="continue" type="submit" ><?php esc_html_e("Continue", 'envothemes-demo-import'); ?><i class="dashicons dashicons-arrow-<?php echo esc_attr($icon); ?>-alt"></i></button>
                        <a class="skip-btn" href="<?php echo $this->get_next_step_link(); ?>"><?php esc_html_e("Skip Step", 'envothemes-demo-import'); ?></a>
                    </div> 
                </form>
            </div>
            <?php
        }

        /**
         * Save Info In Step3
         */
        public function save_envo_customize() {

            if (current_user_can('manage_options') && isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'envo_customize_form')) {
                if (isset($_POST['envo-logo']))
                    set_theme_mod('custom_logo', $_POST['envo-logo']);

                if (isset($_POST['envo-site-title']))
                    update_option('blogname', $_POST['envo-site-title']);

                if (isset($_POST['envo-tagline']))
                    update_option('blogdescription', $_POST['envo-tagline']);

                if (isset($_POST['envo-favicon']))
                    update_option('site_icon', $_POST['envo-favicon']);

                wp_safe_redirect($this->get_next_step_link());
                exit;
            } else {
                print 'Your are not authorized to submit this form';
                exit;
            }
        }

        /**
         * Step 4 ready step
         */
        public function envo_ready_setup() {
            // Image
            $img = plugins_url('/assets/img/end.png', __FILE__);
            ?>

            <div class="envo-ready-wrap envo-wrap">
                <h2><?php esc_html_e("Hooray!", 'envothemes-demo-import'); ?></h2>
                <h1 style="font-size: 30px;"><?php esc_html_e("Your website is ready", 'envothemes-demo-import'); ?></h1>
                <div class="envo-thumb">
                    <img src="<?php echo esc_url($img); ?>" width="600" height="274" />
                </div>

                <div class="envo-wizard-setup-actions">
                    <a class="button button-next button-large" href="<?php echo esc_url(( add_query_arg(array('envo_wizard_hide_notice' => '2nd_notice', 'show' => '1',), admin_url()))); ?>"><?php esc_html_e('View Your Website', 'envothemes-demo-import'); ?></a>
                </div>
            </div>
            <?php
        }

        /**
         * Define cronjob
         */
        public static function cronjob_activation() {
            $new_time_format = time() + (24 * 60 * 60 );
            if (!wp_next_scheduled('add_second_notice')) {
                wp_schedule_event($new_time_format, 'daily', 'add_second_notice');
            }
        }

        /**
         * Delete cronjob
         */
        public static function cronjob_deactivation() {
            wp_clear_scheduled_hook('add_second_notice');
        }

    }

    new EnvoThemes_Demo_Import_Theme_Wizard();

    register_activation_hook(ENVO_FILE_PATH, "EnvoThemes_Demo_Import_Theme_Wizard::install");
    // when deactivate plugin
    register_deactivation_hook(ENVO_FILE_PATH, "EnvoThemes_Demo_Import_Theme_Wizard::uninstall");
    //when activate plugin for automatic second notice
    register_activation_hook(ENVO_FILE_PATH, array("EnvoThemes_Demo_Import_Theme_Wizard", "cronjob_activation"));
    register_deactivation_hook(ENVO_FILE_PATH, array("EnvoThemes_Demo_Import_Theme_Wizard", "cronjob_deactivation"));
endif;