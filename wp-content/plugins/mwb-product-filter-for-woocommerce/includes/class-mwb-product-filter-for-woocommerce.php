<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class MWB_Product_Filter_For_Woocommerce {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      MWB_Product_Filter_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pffw_onboard    To initializsed the object of class onboard.
	 */
	protected $pffw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRODUCT_FILTER_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = PRODUCT_FILTER_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'mwb-product-filter-for-woocommerce';

		$this->product_filter_for_woocommerce_dependencies();
		$this->product_filter_for_woocommerce_locale();
		if ( is_admin() ) {
			$this->mwb_product_filter_for_woocommerce_admin_hooks();
		} else {
			$this->mwb_product_filter_for_woocommerce_public_hooks();
		}
		$this->mwb_product_filter_for_woocommerce_common_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - MWB_Product_Filter_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - MWB_Product_Filter_For_Woocommerce_I18n. Defines internationalization functionality.
	 * - MWB_Product_Filter_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - MWB_Product_Filter_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_filter_for_woocommerce_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-product-filter-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-product-filter-for-woocommerce-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-product-filter-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir( plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'MWB_Product_Filter_For_Woocommerce_Onboarding_Steps' ) ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-product-filter-for-woocommerce-onboarding-steps.php';
			}

			if ( class_exists( 'MWB_Product_Filter_For_Woocommerce_Onboarding_Steps' ) ) {
				$pffw_onboard_steps = new MWB_Product_Filter_For_Woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwb-product-filter-for-woocommerce-public.php';
		}

		// The class responsible for defining all actions that occur in the admin area.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-mwb-product-filter-for-woocommerce-common.php';

		$this->loader = new MWB_Product_Filter_For_Woocommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the MWB_Product_Filter_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_filter_for_woocommerce_locale() {
		$plugin_i18n = new MWB_Product_Filter_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_product_filter_for_woocommerce_admin_hooks() {
		$pffw_plugin_admin = new MWB_Product_Filter_For_Woocommerce_Admin( $this->pffw_get_plugin_name(), $this->pffw_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $pffw_plugin_admin, 'pffw_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $pffw_plugin_admin, 'pffw_admin_enqueue_scripts' );

		// Add settings menu for MWB Product Filter for WooCommerce.
		$this->loader->add_action( 'admin_menu', $pffw_plugin_admin, 'pffw_options_page' );
		$this->loader->add_action( 'admin_menu', $pffw_plugin_admin, 'mwb_pffw_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $pffw_plugin_admin, 'pffw_admin_submenu_page', 15 );
		$this->loader->add_filter( 'pffw_general_settings_array', $pffw_plugin_admin, 'pffw_admin_general_settings_page', 10 );
		$this->loader->add_filter( 'pffw_supprot_tab_settings_array', $pffw_plugin_admin, 'pffw_admin_support_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $pffw_plugin_admin, 'pffw_admin_save_tab_settings' );

		// My custom hooks.
		$this->loader->add_action( 'mwb_pffw_plugin_standard_admin_settings_tabs', $pffw_plugin_admin, 'pffw_add_custom_tabs', 10 );
		// $this->loader->add_action( 'mwb_add_plugins_menus_array', $pffw_plugin_admin, 'men', 10 );
		$this->loader->add_filter( 'mwb_pffw_filter_classes_html', $pffw_plugin_admin, 'pffw_filter_class_html', 10 );
		$this->loader->add_filter( 'mwb_pffw_filter_classes_button', $pffw_plugin_admin, 'pffw_filter_class_button', 10 );
		$this->loader->add_filter( 'filter_adding_popoup', $pffw_plugin_admin, 'pffw_filter_add_form_html', 10 );

		// Custom Hooks.
		$this->loader->add_filter( 'woocommerce_screen_ids', $pffw_plugin_admin, 'mwb_pffw_set_wc_screen_ids' );

		// Hook to add class names if already not added.
		$this->loader->add_action( 'admin_init', $pffw_plugin_admin, 'save_default_class_names' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_product_filter_for_woocommerce_common_hooks() {
		$pffw_plugin_common = new MWB_Product_Filter_For_Woocommerce_Common( $this->pffw_get_plugin_name(), $this->pffw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $pffw_plugin_common, 'pffw_common_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $pffw_plugin_common, 'pffw_common_enqueue_scripts' );

		// Ajax sending hooks.
		$this->loader->add_action( 'wp_ajax_filter_form_data', $pffw_plugin_common, 'filter_form_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_trigger_country_listfilter_form_data', $pffw_plugin_common, 'filter_form_data' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_product_filter_for_woocommerce_public_hooks() {
		$pffw_plugin_public = new MWB_Product_Filter_For_Woocommerce_Public( $this->pffw_get_plugin_name(), $this->pffw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $pffw_plugin_public, 'pffw_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $pffw_plugin_public, 'pffw_public_enqueue_scripts' );
		// Shortcode codes.
		$this->loader->add_action( 'init', $pffw_plugin_public, 'register_filter_shortcode' );
		$this->loader->add_action( 'woocommerce_init', $pffw_plugin_public, 'custom_loader_function' );

		// Reset button shortcode.
		$this->loader->add_action( 'init', $pffw_plugin_public, 'mwb_pf_add_reset_button_shortcode' );

		// Reset button before shop loop.
		$this->loader->add_action( 'woocommerce_before_shop_loop', $pffw_plugin_public, 'mwb_pf_reset_button_before_shop_loop' );

		$this->loader->add_action( 'init', $pffw_plugin_public, 'mwb_pffw_show_instock_items' );

		// Filter according to meta query.
		$this->loader->add_action( 'pre_get_posts', $pffw_plugin_public, 'university_adjust_queries' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function pffw_run() {
		$this->loader->pffw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function pffw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    MWB_Product_Filter_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function pffw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Product_Filter_For_Woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function pffw_get_onboard() {
		return $this->pffw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function pffw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_pffw_plug tabs.
	 *
	 * @return  Array       An key=>value pair of MWB Product Filter for WooCommerce tabs.
	 */
	public function mwb_pffw_plug_default_tabs() {
		$pffw_default_tabs = array();

		$pffw_default_tabs['product-filter-for-woocommerce-general'] = array(
			'title'       => esc_html__( 'General Settings', 'mwb-product-filter-for-woocommerce' ),
			'name'        => 'product-filter-for-woocommerce-general',
		);
		$pffw_default_tabs = apply_filters( 'mwb_pffw_plugin_standard_admin_settings_tabs', $pffw_default_tabs );

		return $pffw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_pffw_plug_load_template( $path, $params = array() ) {

		$pffw_file_path = PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_PATH . $path;

		if ( file_exists( $pffw_file_path ) ) {

			include $pffw_file_path;
		} else {

			/* translators: %s: file path */
			$pffw_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'mwb-product-filter-for-woocommerce' ), $pffw_file_path );
			$this->mwb_pffw_plug_admin_notice( $pffw_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $pffw_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_pffw_plug_admin_notice( $pffw_message, $type = 'error' ) {

		$pffw_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$pffw_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$pffw_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$pffw_classes .= 'notice-success is-dismissible';
				break;

			default:
				$pffw_classes .= 'notice-error is-dismissible';
		}

		$pffw_notice  = '<div class="' . esc_attr( $pffw_classes ) . ' mwb-errorr-8">';
		$pffw_notice .= '<p>' . esc_html( $pffw_message ) . '</p>';
		$pffw_notice .= '</div>';

		echo wp_kses_post( $pffw_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $pffw_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_pffw_plug_system_status() {
		 global $wpdb;
		$pffw_system_status = array();
		$pffw_wordpress_status = array();
		$pffw_system_data = array();

		// Get the web server.
		$pffw_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$pffw_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get the server's IP address.
		$pffw_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$pffw_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$pffw_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'mwb-product-filter-for-woocommerce' );

		// Get the server path.
		$pffw_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'mwb-product-filter-for-woocommerce' );

		// Get the OS.
		$pffw_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get WordPress version.
		$pffw_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get and count active WordPress plugins.
		$pffw_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// See if this site is multisite or not.
		$pffw_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'mwb-product-filter-for-woocommerce' ) : __( 'No', 'mwb-product-filter-for-woocommerce' );

		// See if WP Debug is enabled.
		$pffw_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'mwb-product-filter-for-woocommerce' ) : __( 'No', 'mwb-product-filter-for-woocommerce' );

		// See if WP Cache is enabled.
		$pffw_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'mwb-product-filter-for-woocommerce' ) : __( 'No', 'mwb-product-filter-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$pffw_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get the number of published WordPress posts.
		$pffw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'mwb-product-filter-for-woocommerce' );

		// Get PHP memory limit.
		$pffw_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get the PHP error log path.
		$pffw_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'mwb-product-filter-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$pffw_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get PHP max post size.
		$pffw_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$pffw_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$pffw_system_status['php_architecture'] = '64-bit';
		} else {
			$pffw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$pffw_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Show the number of processes currently running on the server.
		$pffw_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'mwb-product-filter-for-woocommerce' );

		// Get the memory usage.
		$pffw_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$pffw_system_status['is_windows'] = true;
			$pffw_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'mwb-product-filter-for-woocommerce' );
		}

		// Get the memory limit.
		$pffw_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get the PHP maximum execution time.
		$pffw_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'mwb-product-filter-for-woocommerce' );

		// Get outgoing IP address.
		$pffw_system_status['outgoing_ip'] = function_exists( 'wp_remote_get' ) ? wp_remote_get( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'mwb-product-filter-for-woocommerce' );

		$pffw_system_data['php'] = $pffw_system_status;
		$pffw_system_data['wp'] = $pffw_wordpress_status;

		return $pffw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $pffw_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_pffw_plug_generate_html( $pffw_components = array() ) {
		$allowed_html = array(
			'span' => array(
				'class'    => array(),
				'data-tip' => array(),
			),
		);
		if ( is_array( $pffw_components ) && ! empty( $pffw_components ) ) {
			foreach ( $pffw_components as $pffw_component ) {
				switch ( $pffw_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'email':
					case 'text':
						?>
						<div class="mwb-form-group mwb-pffw-<?php echo esc_attr( $pffw_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $pffw_component['id'] ); ?>" class="mwb-form-label">
								<?php
								echo esc_html( $pffw_component['title'] ); // WPCS: XSS ok.
								?>
								<?php
								echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html );
								?>
								</label> 
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<?php if ( 'number' != $pffw_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" style=""><?php echo esc_attr( $pffw_component['placeholder'] ); ?></span>
											<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input class="mdc-text-field__input <?php echo esc_attr( $pffw_component['class'] ); ?>" name="<?php echo isset( $pffw_component['name'] ) ? esc_attr( $pffw_component['name'] ) : esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>" type="<?php echo esc_attr( $pffw_component['type'] ); ?>" value="<?php echo esc_attr( $pffw_component['value'] ); ?>" placeholder="<?php echo esc_attr( $pffw_component['placeholder'] ); ?>" <?php echo ( isset( $pffw_component['required'] ) ? esc_html( $pffw_component['required'] ) . '=' . esc_attr( $pffw_component['required'] ) : '' ); ?>>
								</label>
							</div>
						</div>
						<?php
						break;

					case 'password':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $pffw_component['id'] ); ?>" class="mwb-form-label">
													   <?php
														echo esc_html( $pffw_component['title'] ); // WPCS: XSS ok.
														?>
														<?php echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html ); ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input class="mdc-text-field__input <?php echo esc_attr( $pffw_component['class'] ); ?> mwb-form__password" name="<?php echo esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>" type="<?php echo esc_attr( $pffw_component['type'] ); ?>" value="<?php echo esc_attr( $pffw_component['value'] ); ?>" placeholder="<?php echo esc_attr( $pffw_component['placeholder'] ); ?>">
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
							</div>
						</div>
						<?php
						break;

					case 'textarea':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $pffw_component['id'] ); ?>"><?php echo esc_attr( $pffw_component['title'] ); ?><?php echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html ); ?></label></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea" for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo esc_attr( $pffw_component['placeholder'] ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea class="mdc-text-field__input <?php echo esc_attr( $pffw_component['class'] ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo isset( $pffw_component['name'] ) ? esc_attr( $pffw_component['name'] ) : esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>" placeholder="<?php echo esc_attr( $pffw_component['placeholder'] ); ?>">
																						  <?php
																							echo esc_textarea( $pffw_component['value'] ); // WPCS: XSS ok.
																							?>
																																																																																								</textarea>
									</span>
								</label>
							</div>
						</div>

						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $pffw_component['id'] ); ?>"><?php echo esc_html( $pffw_component['title'] ); ?> <?php echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html ); ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div class="mwb-form-select">
									<select name="<?php echo esc_attr( $pffw_component['id'] ); ?><?php echo ( 'multiselect' === $pffw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>" class="mdl-textfield__input <?php echo esc_attr( $pffw_component['class'] ); ?>" <?php echo 'multiselect' === $pffw_component['type'] ? 'multiple="multiple"' : ''; ?><?php echo ( ( isset( $pffw_component['required'] ) && ! empty( $pffw_component['required'] ) ) ? esc_attr( $pffw_component['required'] ) : '' ); ?>>
										<?php
										foreach ( $pffw_component['options'] as $pffw_key => $pffw_val ) {
											?>
											<option value="<?php echo esc_attr( $pffw_key ); ?>" 
																	  <?php
																		if ( is_array( $pffw_component['value'] ) ) {
																			selected( in_array( (string) $pffw_key, $pffw_component['value'], true ), true );
																		} else {
																			selected( $pffw_component['value'], (string) $pffw_key );
																		}
																		?>
																									>
												<?php echo esc_html( $pffw_val ); ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<?php
						break;

					case 'checkbox':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $pffw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $pffw_component['title'] ); ?>
								<?php echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html ); ?>
								</label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input name="<?php echo esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>" type="checkbox" class="mdc-checkbox__native-control <?php echo esc_attr( isset( $pffw_component['class'] ) ? $pffw_component['class'] : '' ); ?>" value="<?php echo esc_attr( $pffw_component['value'] ); ?>" <?php checked( $pffw_component['value'], '1' ); ?> <?php echo ( ( isset( $pffw_component['required'] ) && ! empty( $pffw_component['required'] ) ) ? esc_attr( $pffw_component['required'] ) : '' ); ?> />
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
								</div>
							</div>
						</div>
						<?php
						break;

					case 'radio':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $pffw_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $pffw_component['title'] ); ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mwb-flex-col">
									<?php
									foreach ( $pffw_component['options'] as $pffw_radio_key => $pffw_radio_val ) {
										?>
										<div class="mdc-form-field">
											<div class="mdc-radio">
												<input name="<?php echo isset( $pffw_component['name'] ) ? esc_attr( $pffw_component['name'] ) : esc_attr( $pffw_component['id'] ); ?>" value="<?php echo esc_attr( $pffw_radio_key ); ?>" type="radio" class="mdc-radio__native-control <?php echo esc_attr( $pffw_component['class'] ); ?>" <?php checked( $pffw_radio_key, $pffw_component['value'] ); ?>>
												<div class="mdc-radio__background">
													<div class="mdc-radio__outer-circle"></div>
													<div class="mdc-radio__inner-circle"></div>
												</div>
												<div class="mdc-radio__ripple"></div>
											</div>
											<label for="radio-1"><?php echo esc_html( $pffw_radio_val ); ?></label>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php
						break;

					case 'radio-switch':
						?>

						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="" class="mwb-form-label"><?php echo esc_html( $pffw_component['title'] ); ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo esc_html( $pffw_component['id'] ); ?>" type="checkbox" id="basic-switch" value="on" class="mdc-switch__native-control" role="switch" aria-checked="
																<?php
																if ( 'on' == $pffw_component['value'] ) {
																	echo 'true';
																} else {
																	echo 'false';
																}
																?>
										" <?php checked( $pffw_component['value'], 'on' ); ?>>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						break;

					case 'button':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label"></div>
							<div class="mwb-form-group__control">
								<button class="mdc-button mdc-button--raised button button-primary" name="<?php echo esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>"><span class="mdc-button__ripple"></span>
									<span class="mdc-button__label"><?php echo esc_attr( $pffw_component['button_text'] ); ?></span>
								</button>
							</div>
						</div>
						<?php
						break;

					case 'submit':
						?>
						<tr valign="top">
							<td scope="row">
								<button class="mdc-button mdc-button--raised button button-primary" name="<?php echo esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>"><span class="mdc-button__ripple"></span>
									<span class="mdc-button__label"><?php echo esc_attr( $pffw_component['button_text'] ); ?></span>
								</button>

							</td>
						</tr>
						<?php
						break;

					case 'media':
						?>
						<div class="mwb-form-group mwb-pffw-<?php echo esc_attr( $pffw_component['type'] ); ?>">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label">
								<?php
								echo esc_html( $pffw_component['title'] ); // WPCS: XSS ok.
								?>
								<?php
								echo wp_kses( wc_help_tip( $pffw_component['description'] ), $allowed_html );
								?>
								</label> 
							</div>
							<div class="mwb-form-group__control">
							<div class="mwb-form-group__control">
								<button class="mdc-button button button-primary mwb_pf_upld" name="<?php echo esc_attr( $pffw_component['id'] ); ?>" id="<?php echo esc_attr( $pffw_component['id'] ); ?>"><span class="mdc-button__ripple"></span>
									<span class="mdc-button__label"><?php esc_html_e( 'Upload loader', 'mwb-product-filter-for-woocommerce' ); ?></span>
								</button>
								<div class="selected_loader">
										
								</div>
								<input type="hidden" value="<?php echo esc_attr( $pffw_component['value'] ); ?>" name="<?php echo esc_attr( $pffw_component['id'] ); ?>">
								<button id="mwb_pf_custom_loader-rmv">
									<?php esc_html_e( 'Remove loader', 'mwb-product-filter-for-woocommerce' ); ?>
								</button>
							</div>
							</div>
						</div>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
