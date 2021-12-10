<?php

/**
 * Fired during plugin activation
 *
 * @link       https://peachpay.app
 * @since      1.0.0
 *
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/includes
 * @author     EBOXNET.com <info@eboxnet.com>
 */
class Woo_Related_Products_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		wrprr_record_analytics( true );
	}

}
