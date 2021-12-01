<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class MWB_Product_Filter_For_Woocommerce_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function pffw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'makewebbetter_page_product_filter_for_woocommerce_menu' == $screen->id || 'makewebbetter_page_system_status_product_filter_for_woocommerce_menu' == $screen->id ) {

			wp_enqueue_style( 'mwb-pffw-select2-css', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-product-filter-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-pffw-meterial-css', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-pffw-meterial-css2', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-pffw-meterial-lite', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-pffw-meterial-icons-css', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

			wp_enqueue_style( $this->plugin_name . '-admin-global', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/mwb-product-filter-for-woocommerce-admin-global.css', array( 'mwb-pffw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/mwb-product-filter-for-woocommerce-admin.css', array(), $this->version, 'all' );

		}
		wp_enqueue_style( $this->plugin_name . 'custom', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/mwb-product-filter-for-woocommerce-admin-custom.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function pffw_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'makewebbetter_page_product_filter_for_woocommerce_menu' == $screen->id || 'makewebbetter_page_system_status_product_filter_for_woocommerce_menu' == $screen->id ) {

			wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );
			wp_register_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), WC_VERSION, true );
			wp_enqueue_script( 'sweet-alert', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/sweet-alert.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-pffw-select2', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-product-filter-for-woocommerce-select2.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-pffw-select2', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-product-filter-for-woocommerce-select2.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-pffw-metarial-js', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-pffw-metarial-js2', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-pffw-metarial-lite', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );
			wp_register_script( $this->plugin_name . 'admin-js', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/mwb-product-filter-for-woocommerce-admin.js', array( 'jquery', 'mwb-pffw-select2', 'mwb-pffw-metarial-js', 'mwb-pffw-metarial-js2', 'mwb-pffw-metarial-lite' ), $this->version, false );
			$filter_value = empty( get_option( 'filter_data' ) ) ? '' : get_option( 'filter_data' );
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'pffw_admin_param',
				array(
					'filter_data'         => $filter_value,
					'ajaxurl'             => admin_url( 'admin-ajax.php' ),
					'reloadurl'           => admin_url( 'admin.php?page=product_filter_for_woocommerce_menu' ),
					'pffw_gen_tab_enable' => get_option( 'pffw_radio_switch_demo' ),
					'nonce'               => wp_create_nonce( 'Form_data_nonce' ),
					'mwb_pf_loader_gif'   => get_option( 'mwb_pf_custom_loader', '' ),
				)
			);
			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
	}

	/**
	 * Adding settings menu for MWB Product Filter for WooCommerce.
	 *
	 * @since    1.0.0
	 */
	public function pffw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/MWB_White-01-01-01.svg', 15 );
			$pffw_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $pffw_menus ) && ! empty( $pffw_menus ) ) {
				foreach ( $pffw_menus as $pffw_key => $pffw_value ) {
					add_submenu_page( 'mwb-plugins', $pffw_value['name'], $pffw_value['name'], 'manage_options', $pffw_value['menu_link'], array( $pffw_value['instance'], $pffw_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_pffw_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}

	/**
	 * Register page IDs for Woocommerce.
	 *
	 * @param array $screen Screen ID.
	 */
	public function mwb_pffw_set_wc_screen_ids( $screen ) {

		$screen_ids = array(
			'makewebbetter_page_system_status_product_filter_for_woocommerce_menu',
			'makewebbetter_page_product_filter_for_woocommerce_menu',
		);

		$screen = array_merge( $screen_ids, $screen );

		return $screen;
	}

	/**
	 * MWB Product Filter for WooCommerce pffw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function pffw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'MWB Product Filter for WooCommerce', 'mwb-product-filter-for-woocommerce' ),
			'slug'            => 'product_filter_for_woocommerce_menu',
			'menu_link'       => 'product_filter_for_woocommerce_menu',
			'instance'        => $this,
			'function'        => 'pffw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * MWB Product Filter for WooCommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * MWB Product Filter for WooCommerce admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function pffw_options_menu_html() {

		include_once PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-product-filter-for-woocommerce-admin-dashboard.php';
	}

	/**
	 * Function to get all products array.
	 *
	 * @return array
	 */
	public function mwb_pffw_get_all_products() {
		$mwb_all_products_array = array();
		$args                   = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		$mwb_all_prod           = new WP_Query( $args );
		foreach ( $mwb_all_prod->posts as $key => $value ) {
			$mwb_all_products_array[ $value->ID ] = $value->post_title;
		}
		return $mwb_all_products_array;
	}

	/**
	 * Function to get custom meta values for filtering.
	 *
	 * @return array
	 */
	public function mwb_all_custom_meta_field() {
		$mwb_prod_id_for_meta = get_option( 'mwb_pf_select_prod_for_meta', 'no_id_selectd' );
		$mwb_all_meta         = get_post_meta( $mwb_prod_id_for_meta );
		$mwb_post_meta_array  = array();
		if ( 'no_id_selectd' !== $mwb_prod_id_for_meta ) {
			foreach ( $mwb_all_meta as $key => $value ) {
				if ( '' !== get_post_meta( $mwb_prod_id_for_meta, $key, true ) ) {
					$mwb_post_meta_array[ $key ] = $key;
				}
			}
		}
		return $mwb_post_meta_array;
	}

	/**
	 * MWB Product Filter for WooCommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $pffw_settings_general Settings fields.
	 */
	public function pffw_admin_general_settings_page( $pffw_settings_general ) {

		$pffw_settings_general = array(
			array(
				'title' => __( 'Enable Product Filter', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable plugin to start the functionality.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'pffw_enable_product_filter',
				'value' => get_option( 'pffw_enable_product_filter' ),
				'class' => 'pffw-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'mwb-product-filter-for-woocommerce' ),
					'no' => __( 'NO', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Select the position of the filter reset button', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'This is the dropdown to select the position of the filter reset button.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'mwb_pf_select_reset_button_pos',
				'value' => get_option( 'mwb_pf_select_reset_button_pos', 3 ),
				'class' => 'pffw-select-class',
				'placeholder' => __( 'Select filter position', 'mwb-product-filter-for-woocommerce' ),
				'options' => array(
					0  => __( 'Use Shortcode', 'mwb-product-filter-for-woocommerce' ),
					1  => __( 'Above products', 'mwb-product-filter-for-woocommerce' ),
					2 => __( 'Above filters', 'mwb-product-filter-for-woocommerce' ),
					3 => __( 'Below filters', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Select the type of the filter', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'This is the dropdown to select the type of the filter.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'mwb_pf_select_filter_type',
				'value' => get_option( 'mwb_pf_select_filter_type', 1 ),
				'class' => 'pffw-select-class',
				'placeholder' => __( 'Select filter type', 'mwb-product-filter-for-woocommerce' ),
				'options' => array(
					0 => __( 'Select option', 'mwb-product-filter-for-woocommerce' ),
					1 => __( 'Highlight filter', 'mwb-product-filter-for-woocommerce' ),
					2 => __( 'Show them separate with cross icon.', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Select the product for meta value filter', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'This is the dropdown to select the product whose meta values are displayed.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'mwb_pf_select_prod_for_meta',
				'value' => get_option( 'mwb_pf_select_prod_for_meta' ),
				'class' => 'pffw-select-class',
				'placeholder' => __( 'Select Product', 'mwb-product-filter-for-woocommerce' ),
				'options' => $this->mwb_pffw_get_all_products(),
			),
			array(
				'title'       => __( 'Shortcode', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Click to copy', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'filter_shortcode',
				'required'    => 'readonly',
				'value'       => '[product_filter_for_woo]',
				'class'       => 'pffw-shortcode-class',
				'placeholder' => __( 'Shortcode for Filter', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Shortcode for reset button', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Click to copy', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'reset_filter_shortcode',
				'required'    => 'readonly',
				'value'       => '[mwb_pf_reset_button]',
				'class'       => 'pffw-shortcode-class',
				'placeholder' => __( 'Shortcode for Filter reset', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Upload custom loader', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'media',
				'description' => __( 'Upload loader using wp-media', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'mwb_pf_custom_loader',
				'value'       => get_option( 'mwb_pf_custom_loader', '' ),
				'class'       => 'pffw-upload-loader-class',
				'placeholder' => __( 'Upload custom loader', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'type'  => 'button',
				'id'    => 'pffw_button_demo',
				'button_text' => __( 'Save Settings', 'mwb-product-filter-for-woocommerce' ),
				'class' => 'pffw-button-class',
			),
		);
		return $pffw_settings_general;
	}

	/**
	 * MWB Product Filter for WooCommerce support page tabs.
	 *
	 * @since    1.0.0
	 * @param    Array $mwb_pffw_support Settings fields.
	 * @return   Array  $mwb_pffw_support
	 */
	public function pffw_admin_support_settings_page( $mwb_pffw_support ) {
		$mwb_pffw_support = array(
			array(
				'title' => __( 'User Guide', 'mwb-product-filter-for-woocommerce' ),
				'description' => __( 'View the detailed guides and documentation to set up your plugin.', 'mwb-product-filter-for-woocommerce' ),
				'link-text' => __( 'VIEW', 'mwb-product-filter-for-woocommerce' ),
				'link' => '',
			),
			array(
				'title' => __( 'Free Support', 'mwb-product-filter-for-woocommerce' ),
				'description' => __( 'Please submit a ticket , our team will respond within 24 hours.', 'mwb-product-filter-for-woocommerce' ),
				'link-text' => __( 'SUBMIT', 'mwb-product-filter-for-woocommerce' ),
				'link' => '',
			),
		);

		return apply_filters( 'mwb_pffw_add_support_content', $mwb_pffw_support );
	}

	/**
	 * MWB Product Filter for WooCommerce save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function pffw_admin_save_tab_settings() {
		global $pffw_mwb_pffw_obj, $error_notice;
		if ( isset( $_POST['general_nonce'] ) ) {
			$general_form_nonce = sanitize_text_field( wp_unslash( $_POST['general_nonce'] ) );
			if ( wp_verify_nonce( $general_form_nonce, 'general-form-nonce' ) ) {
				if ( isset( $_POST['pffw_button_demo'] ) ) {
					$mwb_pffw_gen_flag = false;
					$pffw_genaral_settings = apply_filters( 'pffw_general_settings_array', array() );
					$pffw_button_index = array_search( 'submit', array_column( $pffw_genaral_settings, 'type' ) );
					if ( isset( $pffw_button_index ) && ( null == $pffw_button_index || '' == $pffw_button_index ) ) {
						$pffw_button_index = array_search( 'button', array_column( $pffw_genaral_settings, 'type' ) );
					}
					if ( isset( $pffw_button_index ) && '' !== $pffw_button_index ) {
						unset( $pffw_genaral_settings[ $pffw_button_index ] );
						if ( is_array( $pffw_genaral_settings ) && ! empty( $pffw_genaral_settings ) ) {
							foreach ( $pffw_genaral_settings as $pffw_genaral_setting ) {
								if ( isset( $pffw_genaral_setting['id'] ) && '' !== $pffw_genaral_setting['id'] ) {
									if ( isset( $_POST[ $pffw_genaral_setting['id'] ] ) ) {
										update_option( $pffw_genaral_setting['id'], is_array( $_POST[ $pffw_genaral_setting['id'] ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $pffw_genaral_setting['id'] ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $pffw_genaral_setting['id'] ] ) ) );
									} else {
										update_option( $pffw_genaral_setting['id'], '' );
									}
								} else {
									$mwb_pffw_gen_flag = true;
								}
							}
						}
						if ( $mwb_pffw_gen_flag ) {
							$mwb_pffw_error_text = esc_html__( 'Id of some field is missing', 'mwb-product-filter-for-woocommerce' );
						} else {
							$error_notice = false;
						}
					}
				}
			}
		}
	}

	/**
	 * Pffw_add_custom_tabs
	 *
	 * @param array $tabs for the tab array list.
	 */
	public function pffw_add_custom_tabs( $tabs = array() ) {
		$tabs['filter-setting'] =
			array(
				'title' => esc_html__( 'Filter Settings', 'mwb-product-filter-for-woocommerce' ),
				'name'  => 'filter-setting',
			);
		$tabs['filter-classes'] =
			array(
				'title' => esc_html__( 'Filter Classes', 'mwb-product-filter-for-woocommerce' ),
				'name'  => 'filter-classes',
			);
		$tabs['mwb-pffw-overview'] =
		array(
			'title' => esc_html__( 'Overview', 'mwb-product-filter-for-woocommerce' ),
			'name'  => 'mwb-pffw-overview',
		);
		return $tabs;
	}

	/**
	 * Pffw_filter_class_button
	 *
	 * @param array $pffw_filter_class for the tab array list.
	 */
	public function pffw_filter_class_button( $pffw_filter_class ) {
		$pffw_filter_class = array(
			array(
				'type'  => 'button',
				'id'    => 'pffw_save_filter_classes',
				'button_text' => __( 'Save Settings', 'mwb-product-filter-for-woocommerce' ),
				'class' => 'pffw-button-class',
			),
			array(
				'type'  => 'button',
				'id'    => 'pffw_default_values_reset',
				'button_text' => __( 'Default Values', 'mwb-product-filter-for-woocommerce' ),
				'class' => 'pffw-button-class',
			),
		);
		return $pffw_filter_class;
	}

	/**
	 * Pffw_filter_class_html
	 *
	 * @param array $pffw_filter_class for the tab array list.
	 */
	public function pffw_filter_class_html( $pffw_filter_class ) {
		$pffw = get_option( 'pffw_classes_names' );
		if ( isset( $pffw ) && ! empty( $pffw ) ) {
			foreach ( $pffw as $key => $value ) {
				if ( empty( $pffw[ $key ] ) ) {
					$pffw[ $key ] = '';
				}
			}
		}
		$pffw_filter_class = array(
			array(
				'title'       => __( 'Product Container', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter here the CSS class or id for the product container (Default: .products)', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'product_container',
				'value'       => $pffw['product_container'],
				'class'       => 'pffw-text-class',
				'placeholder' => __( 'Product Container Class Name', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Shop Pagination Container', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter here the CSS class or id for the shop pagination container (Default: nav.woocommerce-pagination)', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'shop_pagination',
				'value'       => $pffw['shop_pagination'],
				'class'       => 'pffw-text-class',
				'placeholder' => __( 'Pagination Container Class Name', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Result Count Container', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter here the CSS class or id for the results count container (Default: .woocommerce-result-count)', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'result_count',
				'value'       => $pffw['result_count'],
				'class'       => 'pffw-text-class',
				'placeholder' => __( 'Result Count Container Class Name', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Scroll up to top anchor', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter here the HTML tag for the scroll up to top feature (Default: .yit-wcan-container)', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'scroll_up_anchor',
				'value'       => $pffw['scroll_up_anchor'],
				'class'       => 'pffw-text-class',
				'placeholder' => __( 'Scroll up to top anchor', 'mwb-product-filter-for-woocommerce' ),
			),
		);
		return $pffw_filter_class;
	}

	/**
	 * Pffw_filter_add_form_html
	 *
	 * @param array $pffw_form_fields for the tab array list.
	 */
	public function pffw_filter_add_form_html( $pffw_form_fields ) {
		// Get product attributes.
		$attributes = wc_get_attribute_taxonomies();
		foreach ( $attributes as $attributename ) {
			$attributes_name = wc_attribute_taxonomy_name( $attributename->attribute_name );
			if ( taxonomy_exists( $attributes_name ) ) {
				$attrij[] = $attributename->attribute_name;
			}
		}
		if ( ! empty( $attrij ) ) {
			$options = array();
			foreach ( $attrij as $key => $value ) {
				$options[ $value ] = $value;
			}
			$options['rating']           = 'Rating';
			$options['price_slider']     = 'Price slider';
		}
		$pffw_form_fields = array(
			array(
				'title'       => __( 'Title', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Title for the filter', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'title',
				'required'    => 'required',
				'value'       => '',
				'class'       => 'pffw-text-class title_form',
				'placeholder' => __( 'Title', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title' => __( 'Filter for', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'Use this for type of filter.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'mwb_pf_type',
				'required' => 'required',
				'value' => '',
				'class' => 'pffw-select-class',
				'options' => array(
					'att' => __( 'Attribute', 'mwb-product-filter-for-woocommerce' ),
					'cus' => __( 'Custom', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Attribute', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'Existing Attributes', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'attribute',
				'required'    => 'required',
				'value' => '',
				'class' => 'pffw-select-class',
				'options' => empty( $options ) ? __( 'No Attribute Found', 'mwb-product-filter-for-woocommerce' ) : $options,
			),
			array(
				'title' => __( 'Select field to select meta values for filtering', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'Select meta value for filtering product.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'pffw_select_for_meta_filter',
				'value' => '',
				'class' => 'pffw-select-class',
				'placeholder' => '',
				'options' => $this->mwb_all_custom_meta_field(),
			),
			array(
				'title'       => __( 'Meta values', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Meta values separated by comma(,)', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'mwb_pf_meta_val',
				'value'       => '',
				'class'       => 'pffw-text-class title_form',
				'placeholder' => __( 'Meta values separated by comma(,)', 'mwb-product-filter-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Type of filter', 'mwb-product-filter-for-woocommerce' ),
				'type'        => 'select',
				'description' => __( 'Use this for filter type.', 'mwb-product-filter-for-woocommerce' ),
				'id'          => 'filter_type',
				'value'       => '',
				'required'    => 'required',
				'class'       => 'pffw-select-class',
				'placeholder' => __( 'Select Demo', 'mwb-product-filter-for-woocommerce' ),
				'options'     => array(
					'List'            => __( 'List', 'mwb-product-filter-for-woocommerce' ),
					'Label'           => __( 'Label', 'mwb-product-filter-for-woocommerce' ),
					'Checkbox'        => __( 'Checkbox', 'mwb-product-filter-for-woocommerce' ),
					'Dropdown'        => __( 'Dropdown', 'mwb-product-filter-for-woocommerce' ),
					'Color-circle'    => __( 'Color (In Circle Shape)', 'mwb-product-filter-for-woocommerce' ),
					'Color-rectangle' => __( 'Color (In Rectangle Shape)', 'mwb-product-filter-for-woocommerce' ),
					'slider'          => __( 'Slider', 'mwb-product-filter-for-woocommerce' ),
					'na'              => __( 'Not applicable', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Query type', 'mwb-product-filter-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'Use this for query type.', 'mwb-product-filter-for-woocommerce' ),
				'id'    => 'query_type',
				'required' => 'required',
				'value' => '',
				'class' => 'pffw-select-class',
				'options' => array(
					'or' => __( 'OR', 'mwb-product-filter-for-woocommerce' ),
					'and' => __( 'AND', 'mwb-product-filter-for-woocommerce' ),
					'na'       => __( 'Not applicable', 'mwb-product-filter-for-woocommerce' ),
				),
			),
			array(
				'type'  => 'submit',
				'id'    => 'submit_button',
				'button_text' => __( 'Save Filter', 'mwb-product-filter-for-woocommerce' ),
			),
		);
		return $pffw_form_fields;
	}

	/**
	 * Function to save default class name.
	 *
	 * @return void
	 */
	public function save_default_class_names() {
		if ( 'no_val' === get_option( 'pffw_classes_names', 'no_val' ) ) {
			$pffw['product_container'] = '.products';
			$pffw['shop_pagination'] = 'nav.woocommerce-pagination';
			$pffw['result_count'] = '.woocommerce-result-count';
			$pffw['scroll_up_anchor'] = '.mwb_pffw_container';
			update_option( 'pffw_classes_names', $pffw );
		}
	}
}
