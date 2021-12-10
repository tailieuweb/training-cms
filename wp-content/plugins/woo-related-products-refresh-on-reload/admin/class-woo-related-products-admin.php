<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://peachpay.app
 * @since      1.0.0
 *
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Related_Products
 * @subpackage Woo_Related_Products/admin
 * @author     EBOXNET.com <info@eboxnet.com>
 */
class Woo_Related_Products_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Related_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Related_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-related-products-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Related_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Related_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-related-products-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Create menu entry the admin area.
	 *
	 * @since    1.0.0
	 */
	public function create_menu() {
	/* 
	add_menu_page('Related Products', 'Related Products', 'administrator', 'woo-related-options', 'wrprr_admin_page');
	Moved the options page inside Woocommerce menu tab
	*/
	add_submenu_page( 'woocommerce', __( 'Related Products', 'woocommerce' ), __( 'Woo Related Products', 'woocommerce' ), 'administrator', 'woo-related-options', 'wrprr_admin_page' );
	}
	/**
	 * Register settings variables
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

	register_setting( 'woorelated-group', 'woorelated_wtitle' );
	register_setting( 'woorelated-group', 'woorelated_nproducts' );
	register_setting( 'woorelated-group', 'woorelated_basedon' );
	register_setting( 'woorelated-group', 'woorelated_exclude' );
	register_setting( 'woorelated-group', 'woorelated_slider' );
	}
}
