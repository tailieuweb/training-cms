<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @review_dismiss()
 * @review_pending()
 * @envothemes_review_notice_message()
 * Make all the above functions working.
 */
function envothemes_review_notice() {

    envothemes_review_dismiss();
    envothemes_review_pending();

    $activation_time = get_site_option('envothemes_active_time');
    $review_dismissal = get_site_option('envothemes_review_dismiss');
    $maybe_later = get_site_option('envothemes_maybe_later');

    if ('yes' == $review_dismissal) {
        return;
    }

    if (!$activation_time) {
        add_site_option('envothemes_active_time', time());
    }

    $daysinseconds = 1209600; // 1209600 14 Days in seconds.
    if ('yes' == $maybe_later) {
        $daysinseconds = 2419200; // 28 Days in seconds.
    }

    if (time() - $activation_time > $daysinseconds) {
        add_action('admin_notices', 'envothemes_review_notice_message');
    }
}

add_action('admin_init', 'envothemes_review_notice');

/**
 * For the notice preview.
 */
function envothemes_review_notice_message() {
    $scheme = (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)) ? '&' : '?';
    $url = $_SERVER['REQUEST_URI'] . $scheme . 'envothemes_review_dismiss=yes';
    $dismiss_url = wp_nonce_url($url, 'envo-review-nonce');

    $_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'envothemes_review_later=yes';
    $later_url = wp_nonce_url($_later_link, 'envo-review-nonce');
    $theme = wp_get_theme();
    $themetemplate = $theme->template;
    $themename = $theme->name;
    ?>

    <div class="envo-review-notice">
        <div class="envo-review-thumbnail">
            <img src="<?php echo esc_url(ENVO_URL) . 'img/et-logo.png'; ?>" alt="">
        </div>
        <div class="envo-review-text">
            <h3><?php esc_html_e('Leave A Review?', 'envothemes-demo-import') ?></h3>
            <p><?php echo sprintf(esc_html__('We hope you\'ve enjoyed using %1$s theme! Would you consider leaving us a review on WordPress.org?', 'envothemes-demo-import'), esc_html($themename)) ?></p>
            <ul class="envo-review-ul">
                <li>
                    <a href="https://wordpress.org/support/theme/<?php echo esc_html($themetemplate); ?>/reviews/?rate=5#new-post" target="_blank">
                        <span class="dashicons dashicons-external"></span>
                        <?php esc_html_e('Sure! I\'d love to!', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $dismiss_url ?>">
                        <span class="dashicons dashicons-smiley"></span>
                        <?php esc_html_e('I\'ve already left a review', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $later_url ?>">
                        <span class="dashicons dashicons-calendar-alt"></span>
                        <?php esc_html_e('Maybe Later', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li>
                    <a href="https://envothemes.com/contact/" target="_blank">
                        <span class="dashicons dashicons-sos"></span>
                        <?php esc_html_e('I need help!', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $dismiss_url ?>">
                        <span class="dashicons dashicons-dismiss"></span>
                        <?php esc_html_e('Never show again', 'envothemes-demo-import') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <?php
}

/**
 * For Dismiss! 
 */
function envothemes_review_dismiss() {

    if (!is_admin() ||
            !current_user_can('manage_options') ||
            !isset($_GET['_wpnonce']) ||
            !wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'envo-review-nonce') ||
            !isset($_GET['envothemes_review_dismiss'])) {

        return;
    }

    add_site_option('envothemes_review_dismiss', 'yes');
}

/**
 * For Maybe Later Update.
 */
function envothemes_review_pending() {

    if (!is_admin() ||
            !current_user_can('manage_options') ||
            !isset($_GET['_wpnonce']) ||
            !wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'envo-review-nonce') ||
            !isset($_GET['envothemes_review_later'])) {

        return;
    }
    // Reset Time to current time.
    update_site_option('envothemes_active_time', time());
    update_site_option('envothemes_maybe_later', 'yes');
}

function envothemes_pro_notice() {

    envothemes_pro_dismiss();

    $activation_time = get_site_option('envothemes_active_pro_time');

    if (!$activation_time) {
        add_site_option('envothemes_active_pro_time', time());
    }

    $daysinseconds = 86400; // 1 Day in seconds.

    if (time() - $activation_time > $daysinseconds) {
        if (defined(defined('ENVO_SHOPPER_PRO_CURRENT_VERSION') || 'ENVO_ECOMMERCE_PRO_CURRENT_VERSION') || defined('ENVO_STOREFRONT_PRO_CURRENT_VERSION') || defined('ENVO_SHOP_PRO_CURRENT_VERSION') || defined('ENVO_ONLINE_STORE_PRO_CURRENT_VERSION') || defined('ENVO_MARKETPLACE_PRO_CURRENT_VERSION') || defined('ENVO_SHOPPER_PRO_CURRENT_VERSION')) {
            return;
        }
        add_action('admin_notices', 'envothemes_pro_notice_message');
    }
}

add_action('admin_init', 'envothemes_pro_notice');

/**
 * For PRO notice 
 */
function envothemes_pro_notice_message() {
    $scheme = (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)) ? '&' : '?';
    $url = $_SERVER['REQUEST_URI'] . $scheme . 'envothemes_pro_dismiss=yes';
    $dismiss_url = wp_nonce_url($url, 'envo-pro-nonce');
    $theme = wp_get_theme();
    $themetemplate = $theme->template;
    $themename = $theme->name;
    ?>

    <div class="envo-review-notice">
        <div class="envo-review-thumbnail">
            <img src="<?php echo esc_url(ENVO_URL) . 'img/et-logo.png'; ?>" alt="">
        </div>
        <div class="envo-review-text">
            <h3><?php esc_html_e('Go PRO for More Features', 'envothemes-demo-import') ?></h3>
            <p>
                <?php echo sprintf(esc_html__('Get the %1$s for more stunning elements, demos and customization options.', 'envothemes-demo-import'), '<a href="https://envothemes.com/product/' . esc_html($themetemplate) . '-pro/" target="_blank">PRO version</a>') ?>
            </p>
            <ul class="envo-review-ul">
                <li class="show-mor-message">
                    <a href="https://envothemes.com/product/<?php echo esc_html($themetemplate); ?>-pro/" target="_blank">
                        <span class="dashicons dashicons-external"></span>
                        <?php esc_html_e('Show me more', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li class="hide-message">
                    <a href="<?php echo $dismiss_url ?>">
                        <span class="dashicons dashicons-smiley"></span>
                        <?php esc_html_e('Hide this message', 'envothemes-demo-import') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <?php
}

/**
 * For PRO Dismiss! 
 */
function envothemes_pro_dismiss() {

    if (!is_admin() ||
            !current_user_can('manage_options') ||
            !isset($_GET['_wpnonce']) ||
            !wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'envo-pro-nonce') ||
            !isset($_GET['envothemes_pro_dismiss'])) {

        return;
    }
    $daysinseconds = 604800; // 14 Days in seconds (1209600).
    $newtime = time() + $daysinseconds;
    update_site_option('envothemes_active_pro_time', $newtime);
}

/**
 * Envo shopper notice
 */
function envothemes_shopper_notice() {

    envothemes_shopper_dismiss();
    
    $theme = wp_get_theme();
    $activation_time = get_site_option('envothemes_active_shopper_time');

    if (!$activation_time) {
        add_site_option('envothemes_active_shopper_time', time());
    }

    $daysinseconds = 300; // 1 Day in seconds.

    if (time() - $activation_time > $daysinseconds) {
        if (defined('ENVO_ECOMMERCE_PRO_CURRENT_VERSION') || defined('ENVO_STOREFRONT_PRO_CURRENT_VERSION') || defined('ENVO_SHOP_PRO_CURRENT_VERSION') || defined('ENVO_ONLINE_STORE_PRO_CURRENT_VERSION') || defined('ENVO_MARKETPLACE_PRO_CURRENT_VERSION') || defined('ENVO_SHOPPER_PRO_CURRENT_VERSION')) {
            return;
        }
        if ( 'Envo Shopper' != $theme->name || 'envo-shopper' != $theme->template ) {
            add_action('admin_notices', 'envothemes_shopper_notice_message');
        }
    }
}

add_action('admin_init', 'envothemes_shopper_notice');

/**
 * For shop notice 
 */
function envothemes_shopper_notice_message() {
    $scheme = (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)) ? '&' : '?';
    $url = $_SERVER['REQUEST_URI'] . $scheme . 'envothemes_shopper_dismiss=yes';
    $dismiss_url = wp_nonce_url($url, 'envo-shopper-nonce');
    $theme = wp_get_theme();
    $themetemplate = $theme->template;
    $themename = $theme->name;
    ?>

    <div class="envo-review-notice envo-shop-notice">
        <div class="envo-review-thumbnail">
            <img src="<?php echo esc_url(ENVO_URL) . 'img/envo-shopper.png'; ?>" alt="">
        </div>
        <div class="envo-review-text">
            <h3><?php esc_html_e('New Awesome FREE WooCommerce Theme - Envo Shopper', 'envothemes-demo-import') ?></h3>
            <p>
                <?php
                echo sprintf(
                        esc_html__('%1$s - new free WooCommerce theme form EnvoThemes. Check out theme %2$s, that can be imported for FREE with simple click.', 'envothemes-demo-import'),
                        '<a href="https://envothemes.com/free-envo-shopper/" target="_blank">Envo Shopper</a>',
                        '<a href="https://envothemes.com/envo-shopper/" target="_blank">Demo</a>')
                ?>
            </p>
            <ul class="envo-review-ul">
                <li class="show-mor-message">
                    <a href="https://envothemes.com/free-envo-shopper/" target="_blank">
                        <span class="dashicons dashicons-external"></span>
                        <?php esc_html_e('Show me more', 'envothemes-demo-import') ?>
                    </a>
                </li>
                <li class="hide-message">
                    <a href="<?php echo $dismiss_url ?>">
                        <span class="dashicons dashicons-smiley"></span>
                        <?php esc_html_e('Hide this message', 'envothemes-demo-import') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <?php
}

/**
 * For shop Dismiss! 
 */
function envothemes_shopper_dismiss() {

    if (!is_admin() ||
            !current_user_can('manage_options') ||
            !isset($_GET['_wpnonce']) ||
            !wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'envo-shopper-nonce') ||
            !isset($_GET['envothemes_shopper_dismiss'])) {

        return;
    }
    $daysinseconds = 1209600; // 14 Days in seconds (1209600).
    $newtime = time() + $daysinseconds;
    update_site_option('envothemes_active_shopper_time', $newtime);
}
