<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://peachpay.app
 * @since      1.0.0
 *
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/includes
 * @author     EBOXNET.com <info@eboxnet.com>
 */
class Woo_Related_Products_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wrprr_record_analytics( false );
	}

}
