<?php
/**
 * Plugin Name: Product Filter by WooBeWoo
 * Plugin URI: https://woobewoo.com/product/woocommerce-filter/
 * Description: Filter products in your store in most efficient way
 * Version: 2.0.2
 * Author: WooBeWoo
 * Author URI: https://woobewoo.com/
 * Text Domain: woo-product-filter
 * Domain Path: /languages
 * WC requires at least: 3.4.0
 * WC tested up to: 5.9.0
 **/
/**
 * Base config constants and functions
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php');
/**
 * Connect all required core classes
 */
if ( trueRequestWpf() ) {
	importClassWpf( 'DbWpf' );
	importClassWpf( 'InstallerWpf' );
	importClassWpf( 'BaseObjectWpf' );
	importClassWpf( 'ModuleWpf' );
	importClassWpf( 'ModelWpf' );
	importClassWpf( 'ViewWpf' );
	importClassWpf( 'ControllerWpf' );
	importClassWpf( 'HelperWpf' );
	importClassWpf( 'DispatcherWpf' );
	importClassWpf( 'FieldWpf' );
	importClassWpf( 'TableWpf' );
	importClassWpf( 'FrameWpf' );
	/**
	 * Deprecated classes
	 *
	 * @deprecated since version 1.0.1
	 */
	importClassWpf( 'LangWpf' );
	importClassWpf( 'ReqWpf' );
	importClassWpf( 'UriWpf' );
	importClassWpf( 'HtmlWpf' );
	importClassWpf( 'ResponseWpf' );
	importClassWpf( 'FieldAdapterWpf' );
	importClassWpf( 'ValidatorWpf' );
	importClassWpf( 'ErrorsWpf' );
	importClassWpf( 'UtilsWpf' );
	importClassWpf( 'ModInstallerWpf' );
	importClassWpf( 'InstallerDbUpdaterWpf' );
	importClassWpf( 'DateWpf' );
	/**
	 * Check plugin version - maybe we need to update database, and check global errors in request
	 */
	InstallerWpf::update();
	ErrorsWpf::init();
	/**
	 * Start application
	 */
	FrameWpf::_()->parseRoute();
	FrameWpf::_()->init();
	FrameWpf::_()->exec();
}
