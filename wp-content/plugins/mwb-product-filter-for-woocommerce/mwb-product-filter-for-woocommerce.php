<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           MWB_Product_Filter_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Product Filter for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/mwb-product-filter-for-woocommerce/
 * Description:       Shows a dynamic product filter option on the product listing page to ease customer to get their choice.
 * Version:           2.0.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mwb-product-filter-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least:        4.6
 * Tested up to:             5.8.1
 * WC requires at least:     4.0
 * WC tested up to:          5.8
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Mwb_pffw_plugin_activation
 *
 * @return $activation for the message.
 */
function mwb_pffw_plugin_activation() {

	$activation['status'] = true;
	$activation['message'] = '';

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// Dependant plugin.
	if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status'] = false;
		$activation['message'] = 'woo_inactive';

	}

	return $activation;
}

$mwb_pffw_plugin_activation = mwb_pffw_plugin_activation();

if ( true === $mwb_pffw_plugin_activation['status'] ) {

	register_activation_hook( __FILE__, 'activate_product_filter_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_product_filter_for_woocommerce' );

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-mwb-product-filter-for-woocommerce-deactivator.php
	 */
	function deactivate_product_filter_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-product-filter-for-woocommerce-deactivator.php';
		MWB_Product_Filter_For_Woocommerce_Deactivator::product_filter_for_woocommerce_deactivate();
		$mwb_pffw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_pffw_deactive_plugin ) && ! empty( $mwb_pffw_deactive_plugin ) ) {
			foreach ( $mwb_pffw_deactive_plugin as $mwb_pffw_deactive_key => $mwb_pffw_deactive ) {
				if ( 'mwb-product-filter-for-woocommerce' === $mwb_pffw_deactive_key ) {
					$mwb_pffw_deactive_plugin[ $mwb_pffw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_pffw_deactive_plugin );
	}


	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-mwb-product-filter-for-woocommerce-activator.php
	 *
	 * @param boolean $network_wide Is network site or not.
	 * @return void
	 */
	function activate_product_filter_for_woocommerce( $network_wide ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-product-filter-for-woocommerce-activator.php';
		MWB_Product_Filter_For_Woocommerce_Activator::product_filter_for_woocommerce_activate( $network_wide );
		$mwb_pffw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_pffw_active_plugin ) && ! empty( $mwb_pffw_active_plugin ) ) {
			$mwb_pffw_active_plugin['mwb-product-filter-for-woocommerce'] = array(
				'plugin_name' => __( 'MWB Product Filter for WooCommerce', 'mwb-product-filter-for-woocommerce' ),
				'active' => '1',
			);
		} else {
			$mwb_pffw_active_plugin = array();
			$mwb_pffw_active_plugin['mwb-product-filter-for-woocommerce'] = array(
				'plugin_name' => __( 'MWB Product Filter for WooCommerce', 'mwb-product-filter-for-woocommerce' ),
				'active' => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_pffw_active_plugin );
	}

	/**
	 * Define plugin constants.
	 *
	 * @since             1.0.0
	 */
	function define_product_filter_for_woocommerce_constants() {

		product_filter_for_woocommerce_constants( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_VERSION', '1.0.1' );
		product_filter_for_woocommerce_constants( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		product_filter_for_woocommerce_constants( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		product_filter_for_woocommerce_constants( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		product_filter_for_woocommerce_constants( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'MWB Product Filter for WooCommerce' );
	}

	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param   String $key    Key for contant.
	 * @param   String $value   value for contant.
	 * @since             1.0.0
	 */
	function product_filter_for_woocommerce_constants( $key, $value ) {

		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-product-filter-for-woocommerce.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_product_filter_for_woocommerce() {
		define_product_filter_for_woocommerce_constants();

		$pffw_plugin_standard = new MWB_Product_Filter_For_Woocommerce();
		$pffw_plugin_standard->pffw_run();
		$GLOBALS['pffw_mwb_pffw_obj'] = $pffw_plugin_standard;
		$GLOBALS['error_notice'] = true;

	}
	run_product_filter_for_woocommerce();

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param array  $links_array array containing the links to plugin.
	 * @param string $plugin_file_name plugin file name.
	 * @return array
	 */
	function pffw_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		$doc_str     = __( 'Documentation', 'mwb-product-filter-for-woocommerce' );
		$demo_str    = __( 'Demo', 'mwb-product-filter-for-woocommerce' );
		$support_str = __( 'Support', 'mwb-product-filter-for-woocommerce' );
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a href="https://demo.makewebbetter.com/mwb-product-filter-for-woocommerce/?utm_source=MWB-productfilter-org&utm_medium=MWB-backend-page&utm_campaign=MWB-productfilter-demo" target="_blank"><img src="' . PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/Demo.svg" class="mwb_pffw_plugin_extra_custom_tab"></i>' . $demo_str . '</a>';
			$links_array[] = '<a href="https://docs.makewebbetter.com/mwb-product-filter-for-woocommerce/?utm_source=MWB-productfilter-org&utm_medium=MWB-backend-page&utm_campaign=MWB-productfilter-doc" target="_blank"><img src="' . PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/Documentation.svg" class="mwb_pffw_plugin_extra_custom_tab"></i>' . $doc_str . '</a>';
			$links_array[] = '<a href="https://makewebbetter.com/submit-query/?utm_source=MWB-productfilter-org&utm_medium=MWB-backend-page&utm_campaign=MWB-productfilter-support" target="_blank"><img src="' . PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/Support.svg" class="mwb_pffw_plugin_extra_custom_tab"></i> ' . $support_str . ' </a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'pffw_custom_settings_at_plugin_tab', 10, 2 );
	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'product_filter_for_woocommerce_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since    1.0.0
	 * @param   Array $links    Settings link array.
	 */
	function product_filter_for_woocommerce_settings_link( $links ) {

		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=product_filter_for_woocommerce_menu' ) . '">' . __( 'Settings', 'mwb-product-filter-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $links );
	}
} else {

	add_action( 'admin_init', 'mwb_pffw_plugin_activation_failure' );

	/**
	 * Mwb_pffw_plugin_activation_failure
	 */
	function mwb_pffw_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_pffw_plugin_activation_admin_notice' );

	/**
	 * Mwb_pffw_plugin_activation_admin_notice
	 *
	 * This function is used to display plugin activation error notice.
	 */
	function mwb_pffw_plugin_activation_admin_notice() {

		global $mwb_pffw_plugin_activation;

		// to hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

		<?php if ( 'woo_inactive' == $mwb_pffw_plugin_activation['message'] ) : ?>
			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce', 'mwb-product-filter-for-woocommerce' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'mwb-product-filter-for-woocommerce' ); ?><strong><?php esc_html_e( 'MWB Product Filter for WooCommerce', 'mwb-product-filter-for-woocommerce' ); ?></strong><?php esc_html_e( '.' ); ?></p>
			</div>

			<?php
		endif;
	}
}

/**
 * Function for multisite handling.
 *
 * @param object $new_site $new_site info.
 * @return void
 */
function mwb_standard_plugin_on_create_blog( $new_site ) {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}
	// check if the plugin has been activated on the network.
	if ( is_plugin_active_for_network( 'mwb-standard-plugin/mwb-standard-plugin.php' ) ) {
		$blog_id = $new_site->blog_id;
		// switch to newly created site.
		switch_to_blog( $blog_id );
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-standard-plugin-activator.php';
		// code to be executed when site is created, call any function from activation file.
			restore_current_blog();
	}
}
add_action( 'wp_initialize_site', 'mwb_standard_plugin_on_create_blog', 900 );
