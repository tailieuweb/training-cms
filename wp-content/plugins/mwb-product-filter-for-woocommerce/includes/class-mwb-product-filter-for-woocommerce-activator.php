<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class MWB_Product_Filter_For_Woocommerce_Activator {

	/**
	 * Function to activate on multisite.
	 *
	 * @param boolean $network_wide variable.
	 * @return void
	 */
	public static function product_filter_for_woocommerce_activate( $network_wide ) {
		global $wpdb;
		// Check if the plugin has been activated on the network.
		if ( is_multisite() && $network_wide ) {
			// Get all blogs in the network and activate plugins on each one.
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				// code to be executed.
				restore_current_blog();
			}
		}
	}
}
