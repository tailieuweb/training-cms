<?php
if (!defined('ABSPATH')) {
    exit;
}

Class WizardAjax {

    public function __construct() {
        add_action('wp_ajax_envo_wizard_ajax_get_demo_data', array($this, 'ajax_demo_data'));
    }

    public function ajax_demo_data() {


        if (!wp_verify_nonce($_GET['demo_data_nonce'], 'get-demo-data')) {
            die('This action was stopped for security purposes.');
        }

        // Database reset url
        if (is_plugin_active('wordpress-database-reset/wp-reset.php')) {
            $plugin_link = admin_url('tools.php?page=database-reset');
        } else {
            $plugin_link = admin_url('plugin-install.php?s=Wordpress+Database+Reset&tab=search');
        }

        // Get all demos
        $demos = EnvoThemes_Demos::get_demos_data();

        // Get selected demo
        $demo = $_GET['demo_name'];

        // Get required plugins
        $plugins = $demos[$demo]['required_plugins'];

        // Get free plugins
        $free = $plugins['free'];

        // Get premium plugins
        $premium = $plugins['premium'];
        ?>

        <div id="envo-demo-plugins">

            <h2 class="title"><?php echo sprintf(esc_html__('Import the %1$s demo', 'envothemes-demo-import'), esc_attr($demos[$demo]['demo_name'])); ?></h2>

            <div class="envo-popup-text">

                <p><?php
                    echo
                    sprintf(
                            esc_html__('Importing demo data allow you to quickly edit everything instead of creating content from scratch. It is recommended uploading sample data on a fresh WordPress install to prevent conflicts with your current content. You can use this plugin to reset your site if needed: %1$sWordpress Database Reset%2$s.', 'envothemes-demo-import'), '<a href="' . $plugin_link . '" target="_blank">', '</a>'
                    );
                    ?></p>

                <div class="envo-required-plugins-wrap">
                    <h3><?php esc_html_e('Required Plugins', 'envothemes-demo-import'); ?></h3>
                    <p><?php esc_html_e('For your site to look exactly like this demo, the plugins below need to be activated.', 'envothemes-demo-import'); ?></p>
                    <div class="envo-required-plugins oe-plugin-installer">
                        <?php
                        EnvoThemes_Demos::required_plugins($free, 'free');
                        EnvoThemes_Demos::required_plugins($premium, 'premium');
                        ?>
                    </div>
                </div>

            </div>


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
            <input type="submit" name="submit" class="envo-button envo-import" value="<?php esc_html_e('Import', 'envothemes-demo-import'); ?>"  />

        </form>

        <div class="envo-loader">
            <h2 class="title"><?php esc_html_e('The import process could take some time, please be patient', 'envothemes-demo-import'); ?></h2>
            <div class="envo-import-status envo-popup-text"></div>
        </div>

        <div class="envo-last">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
            <h3><?php esc_html_e('Demo Imported!', 'envothemes-demo-import'); ?></h3>
        </div>
        <div class="envo-error" style="display: none;">
                <p ><?php esc_html_e("The import didn't import well please contact the support.", 'envothemes-demo-import'); ?></p>
            </div>
        </div>


        <?php
        die();
    }

}

new WizardAjax();
