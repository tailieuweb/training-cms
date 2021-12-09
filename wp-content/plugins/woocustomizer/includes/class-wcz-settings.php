<?php
/**
 * Settings class file.
 *
 * @package StoreCustomizer/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings class.
 */
class WooCustomizer_Settings {

	/**
	 * The single instance of WooCustomizer_Settings.
	 *
	 * @var     object
	 * @access  private
	 * @since   1.0.0
	 */
	private static $_instance = null; //phpcs:ignore

	/**
	 * The main plugin object.
	 *
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	/**
	 * Constructor function.
	 *
	 * @param object $parent Parent object.
	 */
	public function __construct( $parent ) {
		$this->parent = $parent;

		$this->base = 'wcz_';

		// Initialise settings.
		add_action( 'init', array( $this, 'wcz_init_settings' ), 11 );

		// Register plugin settings.
		add_action( 'admin_init', array( $this, 'wcz_register_settings' ) );

		// Add settings page to menu.
		add_action( 'admin_menu', array( $this, 'wcz_add_menu_item' ) );

		// Configure placement of plugin settings page. See readme for implementation.
		add_filter( $this->base . 'wcz_menu_settings', array( $this, 'wcz_configure_settings' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'wcz_add_plugins_settings_link' ) );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function wcz_add_plugins_settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=wcz_settings">' . esc_html__( 'Settings', 'woocustomizer' ) . '</a>';
		array_push( $links, $settings_link );
		
  		return $links;
	}

	/**
	 * Initialise settings
	 *
	 * @return void
	 */
	public function wcz_init_settings() {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 *
	 * @return void
	 */
	public function wcz_add_menu_item() {

		$args = $this->wcz_menu_settings();

		// Do nothing if wrong location key is set.
		if ( is_array( $args ) && isset( $args['location'] ) && function_exists( 'add_' . $args['location'] . '_page' ) ) {
			switch ( $args['location'] ) {
				case 'options':
				case 'submenu':
					$page = add_submenu_page( $args['parent_slug'], $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'] );
					break;
				case 'menu':
					$page = add_menu_page( $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'], $args['icon_url'], $args['position'] );
					break;
				default:
					return;
			}
			add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
		}
	}

	/**
	 * Prepare default settings page arguments
	 *
	 * @return mixed|void
	 */
	private function wcz_menu_settings() {
		return apply_filters(
            $this->base . 'wcz_menu_settings',
			array(
				'location'    => 'submenu', // Possible settings: options, menu, submenu.
				'parent_slug' => 'woocommerce',
				'page_title'  => __( 'StoreCustomizer', 'woocustomizer' ),
				'menu_title'  => __( 'StoreCustomizer', 'woocustomizer' ) . '<span class="wcznotif"></span>',
				'capability'  => 'manage_options',
				'menu_slug'   => $this->parent->_token . '_settings',
				'function'    => array( $this, 'settings_page' ),
				'icon_url'    => '',
				'position'    => null,
			)
        );
	}

	/**
	 * Container for settings page arguments
	 *
	 * @param array $settings Settings array.
	 *
	 * @return array
	 */
	public function wcz_configure_settings( $settings = array() ) {
		return $settings;
	}

	/**
	 * Load settings JS & CSS
	 *
	 * @return void
	 */
	public function settings_assets() {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below.
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );

		// We're including the WP media scripts here because they're needed for the image upload field.
		// If you're not including an image upload then you can leave this function call out.
		wp_enqueue_media();

		wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0', true );
		wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Build settings fields
	 *
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {
		if ( !is_admin() )
			return;

		// FREE Version Settings
		if ( ! wcz_fs()->can_use_premium_code() ) {

			$settings['wcz_general'] = array(
				'title'       => __( 'StoreCustomizer', 'woocustomizer' ),
				'description' => '<b>Note:</b> All settings for StoreCustomizer are built into the WordPress Customizer.<br />Please go to <b>Appearance -> Customize -> StoreCustomizer</b>',
				'fields'      => array(
					array(
						'id'          => 'set_general_tour',
						'label'       => __( 'Turn off the Customizer Tour', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
					array(
						'id'          => 'set_data_to_delete',
						'label'       => __( 'Delete all plugin data when StoreCustomizer is deleted', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
			);
			// Catalogue Mode Promo Tab
			$settings['wcz_catalogue'] = array(
				'title'       => __( 'Catalogue Mode', 'woocustomizer' ),
				'description' => __( 'These are settings to turn your online store into Catalogue Mode so users can only browse products and not purchase them for the time period set.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'catalogue_mode_promo',
						'label'       => __( 'Catalogue Mode', 'woocustomizer' ),
						'description' => __( 'Upgrade from only <b>$49</b> to unlock these extra Pro features', 'woocustomizer' ),
						'type'        => 'promo',
						'default'     => '',
						'top_txt' => __( 'Easily remove the purchase functionality from your shop, turning your online store into a beautiful online catalogue. Apply these settings to all products, selected products, or only to logged out users, prompting users to create an account and log in to purchase your products.', 'woocustomizer' ),
					),
				),
			);
			// Menu Cart Promo Tab
			$settings['wcz_menu_cart'] = array(
				'title'       => __( 'Menu Cart', 'woocustomizer' ),
				'description' => __( 'Easily add a WooCommerce Menu Cart to your site navigation.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'menu_cart_promo',
						'label'       => __( 'Menu Cart', 'woocustomizer' ),
						'description' => __( 'Upgrade from only <b>$49</b> to unlock these extra Pro features', 'woocustomizer' ),
						'type'        => 'promo',
						'default'     => '',
						'top_txt' => __( 'Simply turn on Menu Cart and select which menu you’d like to display a WooCommerce cart in. Add a drop down mini cart basket so your users can add or remove products, view their cart or go straight to checkout.', 'woocustomizer' ),
					),
				)
			);
			// Product Quick View Promo Tab
			$settings['wcz_product_quickview'] = array(
				'title'       => __( 'Product Quick View', 'woocustomizer' ),
				'description' => __( 'Add a Quick View Popup to your WooCommerce Products.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'product_quickview_promo',
						'label'       => __( 'Product Quick View', 'woocustomizer' ),
						'description' => __( 'Upgrade from only <b>$49</b> to unlock these extra Pro features', 'woocustomizer' ),
						'type'        => 'promo',
						'default'     => '',
						'top_txt' => __( 'Give your users the option to preview your products and easily \'add to cart\' or browse the images from within a popup on your shop page, or click through to the product page after they\'ve seen it all.', 'woocustomizer' ),
					),
				),
			);
			// Ajax Search Promo Tab
			$settings['wcz_ajax_search'] = array(
				'title'       => __( 'Ajax Search', 'woocustomizer' ),
				'description' => __( 'Add Ajax Search functionlaity to make finding your products quicker and easier.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'ajax_search_promo',
						'label'       => __( 'Ajax Product Search', 'woocustomizer' ),
						'description' => __( 'Upgrade from only <b>$49</b> to unlock these extra Pro features', 'woocustomizer' ),
						'type'        => 'promo',
						'default'     => '',
						'top_txt' => __( 'Want to speed up users finding your products? Add simple ajax product search to your search bar and configure a bunch of settings to display a prediction of products when your users start typing to search through your products.', 'woocustomizer' ),
					),
				),
			);
			// Custom Thank You Pages Promo Tab
			$settings['wcz_thank_you'] = array(
				'title'       => __( 'Thank You Page(s)', 'woocustomizer' ),
				'description' => __( 'The after purchase Thank You page is a very powerful place to get your users to sign up to your newsletter, show how to use the products, or to advertise other products that they might like<br /><br />They have just purchased something from you so they already trust you and want your products.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'thank_you_promo',
						'label'       => __( 'Custom Thank You Pages', 'woocustomizer' ),
						'description' => __( 'Upgrade from only <b>$49</b> to unlock these extra Pro features', 'woocustomizer' ),
						'type'        => 'promo',
						'default'     => '',
						'top_txt' => __( 'StoreCustomizer offers the ability to build your own custom Thank You pages for WooCommerce, using default WordPress or any page builder you like, and to redirect the customer to your new default Thank You page, redirect them to different pages depending on the products they\'ve just bought, or to pages depending how they purchased the products on your store.', 'woocustomizer' ),
					),
				),
            );
            // Handheld Footer Bar Settings Tab
			$settings['wcz_handheld_footer'] = array(
				'title'       => __( 'Handheld Footer Bar', 'woocustomizer' ),
				'description' => __( 'Make navigating your products and proceeding to the cart or checkout pages on your store even quicker and easier for all users on handheld devices.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'handheld_footer_promo',
						'label'       => __( 'Handheld Footer Bar', 'woocustomizer' ),
						'description' => 'Upgrade from only <b>$49</b> to unlock these extra Pro features',
						'type'        => 'promo',
                        'default'     => '',
                        'top_txt' => __( 'Your users can easily search for products, proceed to checkout, or view their account pages from anywhere within your store when on mobile or tablet devices. StoreCustomizer Pro gives you a neat footer navigation bar for handheld devices. Plus you are able to further customize the footer navigation bar to suit your website design.', 'woocustomizer' ),
					),
				),
            );
            // Product Badges Settings Tab
			$settings['wcz_product_badges'] = array(
				'title'       => __( 'Product Badges', 'woocustomizer' ),
				'description' => __( 'Add custom badges to your WooCommerce Products.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'custom_product_badges_promo',
						'label'       => __( 'WooCommerce Product Badges', 'woocustomizer' ),
						'description' => 'Upgrade from only <b>$49</b> to unlock these extra Pro features',
						'type'        => 'promo',
                        'default'     => '',
                        'top_txt' => __( 'Do you want fancy badges for your WooCommerce Products? Turn on StoreCustomizer Product Badges and start creating your own badges under Products -> Product Badges.', 'woocustomizer' ),
					),
				),
			);
			
		} // FREE Version Settings

		// PREMIUM Version Settings
		if ( wcz_fs()->can_use_premium_code() ) {

			$settings['wcz_general'] = array(
				'title'       => __( 'StoreCustomizer', 'woocustomizer' ),
				'description' => __( '<b>Note:</b> All settings for StoreCustomizer are built into the WordPress Customizer.<br />Please go to <b>Appearance -> Customize -> StoreCustomizer</b>' ),
				'fields'      => array(
					array(
						'id'          => 'set_general_tour',
						'label'       => __( 'Turn off the Customizer Tour', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
					array(
						'id'          => 'set_data_to_delete',
						'label'       => __( 'Delete all plugin data when StoreCustomizer is deleted', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
			);
			// Catalogue Mode Settings Tab
			$settings['wcz_catalogue'] = array(
				'title'       => __( 'Catalogue Mode', 'woocustomizer' ),
				'description' => __( 'These are settings to turn your online store into Catalogue Mode so users can only browse products and not purchase them for the time period set.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_catalogue_mode',
						'label'       => __( 'Enable Catalogue Mode', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
			);
			// Get Theme Menu Locations for Menu Cart
			$wcz_arr = array( 'none' => 'None' );

            $wcz_menus = get_registered_nav_menus();
			foreach ( $wcz_menus as $location => $description ) {
                $wcz_arr[$location] = $description;
            }
            
            $wcz_allmenus = wp_get_nav_menus();
			foreach ( $wcz_allmenus as $wcz_allmenu ) {
                $wcz_arr[$wcz_allmenu->slug] = $wcz_allmenu->name;
            }

			// Menu Cart Settings Tab
			$settings['wcz_menu_cart'] = array(
				'title'       => __( 'Menu Cart', 'woocustomizer' ),
				'description' => __( 'Easily add a WooCommerce Menu Cart to your site navigation.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_menu_cart',
						'label'       => __( 'Enable Menu Cart', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
					array(
						'id'          => 'set_menu_cart_menu',
						'label'       => __( 'Select which Menu to add a Menu Cart to', 'woocustomizer' ),
						'description' => '',
						'type'        => 'select',
						'options'     => array_unique( $wcz_arr ),
						'default'     => 'none',
                    ),
				)
			);
			// Product Quick View Settings Tab
			$settings['wcz_product_quickview'] = array(
				'title'       => __( 'Product Quick View', 'woocustomizer' ),
				'description' => __( 'Add a Quick View Popup to your WooCommerce Products.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_product_quickview',
						'label'       => __( 'Enable Product Quick View', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
			);
			// Ajax Search Settings Tab
			$settings['wcz_ajax_search'] = array(
				'title'       => __( 'Ajax Search', 'woocustomizer' ),
				'description' => __( 'Add Ajax Search functionlaity to make finding your products quicker and easier.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_ajax_search',
						'label'       => __( 'Enable Ajax Search', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
			);
			// Custom Thank You Pages Settings Tab
			$wcz_pages = get_pages(
				array (
					'parent'  => 0, // replaces 'depth' => 1,
					'exclude' => ''
				)
			); // Get Pages
			$wcz_page_ids = wp_list_pluck( $wcz_pages, 'ID' );
			$wcz_pages_list = array( 'pid-default' => 'Default Order Received Page' );

			foreach ( $wcz_page_ids as $wcz_page_id ) {
				$wcz_pages_list['pid-'.$wcz_page_id] = get_the_title( $wcz_page_id );
			}
			// Remove Pages to select
			unset( $wcz_pages_list['pid-' . get_option( 'page_on_front' )] ); // Home
			unset( $wcz_pages_list['pid-' . get_option( 'page_for_posts' )] ); // Blog
			// WooCommerce Pages
			unset( $wcz_pages_list['pid-' . wc_get_page_id( 'myaccount' )] );
			unset( $wcz_pages_list['pid-' . wc_get_page_id( 'shop' )] );
			unset( $wcz_pages_list['pid-' . wc_get_page_id( 'cart' )] );
			unset( $wcz_pages_list['pid-' . wc_get_page_id( 'checkout' )] );

			$settings['wcz_thank_you'] = array(
				'title'       => __( 'Thank You Page(s)', 'woocustomizer' ),
				'description' => __( 'Set an after purchase Custom Thank You Page.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_cthank_you',
						'label'       => __( 'Enable Custom Thank You Pages', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
					array(
						'id'          => 'set_ctp_default_page',
						'label'       => __( 'Select a default Purchase Thank You Page', 'woocustomizer' ),
						'description' => '',
						'type'        => 'select',
						'options'     => $wcz_pages_list,
						'default'     => 'default',
					),
					array(
						'id'          => 'set_ctp_type',
						'label'       => __( 'Select How You Want To Create Thank You Pages', 'woocustomizer' ),
						'description' => '',
						'type'        => 'select',
						'options' => array(
							'wcz_ctp_type_default' => __( 'Use Only The One Custom Page Above', 'woocustomizer' ),
							'wcz_ctp_type_product_level' => __( 'Create Thank You Pages Per Product', 'woocustomizer' ),
							'wcz_ctp_type_payment_type' => __( 'Create Thank You Pages Per Payment Type', 'woocustomizer' )
						),
						'default'     => 'wcz_ctp_type_default',
					),
					array(
						'id'          => 'set_ctp_help',
						'label'       => __( 'See StoreCustomizer Documentation', 'woocustomizer' ),
						'description' => __( 'View Documentation', 'woocustomizer' ),
						'type'        => 'doclinkout',
						'placeholder'     => esc_url( 'https://storecustomizer.com/documentation/' ),
					)
				)
            );
            // Handheld Footer Bar Settings Tab
			$settings['wcz_handheld_footer'] = array(
				'title'       => __( 'Handheld Footer Bar', 'woocustomizer' ),
				'description' => __( 'Turn on a neat Footer Bar Navigation for handheld (mobile) devices.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_handheld_footerbar',
						'label'       => __( 'Enable Handheld Footer Bar', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
				),
            );

			// Get Product Badges Post Type to select a badge to replace the default Sale Badge
			$wcz_pbadges = new WP_Query( array( 'post_type' => 'wcz-badges' ) );
			$badges = $wcz_pbadges->posts;
			
			$wcz_badgelist = array( 'id-default' => 'Default Sale Badge' );
			if ( 'on' == get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) ) {
				foreach( $badges as $badge ) {
					$badgename = get_the_title( $badge->ID ) ? get_the_title( $badge->ID ) : $badge->ID;
					$wcz_badgelist['id-' . $badge->ID] = $badgename;
				}
			}

			$settings['wcz_product_badges'] = array(
				'title'       => __( 'Product Badges', 'woocustomizer' ),
				'description' => __( 'Do you want fancy badges for your WooCommerce Products?<br />Turn on StoreCustomizer Product Badges and start creating your own badges under <b>Products -> Product Badges</b>.', 'woocustomizer' ),
				'fields'      => array(
					array(
						'id'          => 'set_enable_product_badges',
						'label'       => __( 'Enable Product Badges', 'woocustomizer' ),
						'description' => '',
						'type'        => 'checkbox',
						'default'     => '',
					),
					array(
						'id'          => 'set_pb_help',
						'label'       => 'on' == get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) ? __( 'Go to Product Badges', 'woocustomizer' ) : '',
						'description' => 'on' == get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) ? __( 'Product Badges', 'woocustomizer' ) : '',
						'type'        => 'doclinkin',
						'placeholder' => 'on' == get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) ? esc_url( admin_url( 'edit.php?post_type=wcz-badges' ) ) : '',
					),
					array(
						'id'          => 'set_default_sale_badge',
						'label'       => __( 'Replace the default sale badge', 'woocustomizer' ),
						'description' => '',
						'type'        => 'select',
						'options'     => $wcz_badgelist,
						'default'     => 'id-default',
					),
				),
			);

		} // PREMIUM Version Settings

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 *
	 * @return void
	 */
	public function wcz_register_settings() {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab.
			//phpcs:disable
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = sanitize_text_field( $_POST['tab'] );
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = sanitize_text_field( $_GET['tab'] );
				}
			}
			//phpcs:enable

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section !== $section ) {
					continue;
				}

				// Add section to page.
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field.
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field.
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page.
					add_settings_field(
						$field['id'],
						$field['label'],
						array( $this->parent->admin, 'display_field' ),
						$this->parent->_token . '_settings',
						$section,
						array(
							'field'  => $field,
							'prefix' => $this->base,
						)
					);

				}

				if ( ! $current_section ) {
					break;
				}
			}
		}
	}

	/**
	 * Settings section.
	 *
	 * @param array $section Array of section ids.
	 * @return void
	 */
	public function settings_section( $section ) {
		$html = '<p class="wcz-settings-desc"> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html; //phpcs:ignore
	}

	/**
	 * Load settings page content.
	 *
	 * @return void
	 */
	public function settings_page() {
		// Build page HTML.
		$html    = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
        $html 	.= '<h2>' . __( 'StoreCustomizer', 'woocustomizer' ) . '</h2>' . "\n";

			$tab = '';
		//phpcs:disable
		if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
			$tab .= sanitize_text_field( $_GET['tab'] );
		}
		//phpcs:enable

		// Show page tabs.
		if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {
			
			$html .= '<div class="wcz-setwrap">' . "\n";
			$html .= '<h2 class="nav-tab-wrapper">' . "\n";

			$c = 0;
			foreach ( $this->settings as $section => $data ) {

				// Set tab class.
				$class = 'nav-tab';
				if ( ! isset( $_GET['tab'] ) ) { //phpcs:ignore
					if ( 0 === $c ) {
						$class .= ' nav-tab-active';
					}
				} else {
					if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) { //phpcs:ignore
						$class .= ' nav-tab-active';
					}
				}

				// Set tab link.
				$tab_link = add_query_arg( array( 'tab' => $section ) );
				if ( isset( $_GET['settings-updated'] ) ) { //phpcs:ignore
					$tab_link = remove_query_arg( 'settings-updated', $tab_link );
				}

				// Output tab.
                $tabnew = substr( $data['title'], 0, 5 );
                // var_dump( $tabnew );

				$tabisnew = '';
				// if ( wcz_fs()->can_use_premium_code() ) {
				// 	if ( 'produ' == strtolower( $tabnew ) ) { // ADJUST FOR NEW TABS
				// 		 $tabisnew = '<span class="isnew">BETA</span>';
				// 	}
				// }

				$html .= '<a href="' . esc_url( $tab_link ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . $tabisnew . '</a>' . "\n";

				++$c;
			}

			$html .= '</h2>' . "\n";
		}

            $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
                // Only displayed in the free version
                if ( wcz_fs()->can_use_premium_code() ) {
                    $html .= '<div class="wcz-pro-settings ' . esc_attr( $tab ) . '">';
                } else {
                    $html .= '<div class="wcz-free-settings ' . esc_attr( $tab ) . '">';
                }

                    // Get settings fields.
                    ob_start();
                    settings_fields( $this->parent->_token . '_settings' );
                    do_settings_sections( $this->parent->_token . '_settings' );
                    $html .= ob_get_clean();

                    $html     .= '<p class="submit">' . "\n";
                        $html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
                        $html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings', 'woocustomizer' ) ) . '" />' . "\n";
                    $html     .= '</p>' . "\n";

                    if ( ( isset( $_GET['page'] ) && 'wcz_settings' == $_GET['page'] && !isset( $_GET['tab'] ) ) || ( isset( $_GET['tab'] ) && 'wcz_general' == $_GET['tab'] ) ) {
                        $html .= '<div class="wcz-video-wrap">' . "\n";
                        $html .= '<h4>' . esc_attr( __( 'Using StoreCustomizer', 'woocustomizer' ) ) . '</h4>';
                        $html .= '<p>' . esc_attr( __( 'Watch our \'getting started\' video on how to use StoreCustomizer', 'woocustomizer' ) ) . '</p>';
                        $html .= '<div class="wcz-video"><div class="wcz-vid"><iframe width="635" height="357" src="https://www.youtube.com/embed/Byr4Lr6qUaY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>' . "\n";
                        $html .= '</div>' . "\n";
                    }
                    
			    $html .= '</div>';
			$html         .= '</form>' . "\n";
		$html             .= '</div><div class="wcz-customizer">' . "\n";
		$html             .= '<div class="wcz-customizer-links">' . "\n";
            $html             .= '<a href="' . esc_url( wcz_fs()->get_account_url() ) . '" class="wcz-acc-account">' . esc_html( __( 'Account', 'woocustomizer' ) ) . '</a>' . "\n";
			// Only displayed in the free version
			if ( ! wcz_fs()->can_use_premium_code() ) {
				$html             .= '<a href="' . esc_url( wcz_fs()->get_upgrade_url() ) . '" class="wcz-upgrade wcz-acc-upgrade">' . esc_html( __( 'Upgrade', 'woocustomizer' ) ) . '</a>' . "\n";
                $html             .= '<a href="' . esc_url( admin_url( 'admin.php?billing_cycle=annual&trial=true&page=wcz_settings-pricing' ) ) . '" class="wcz-acc-trial">' . esc_html( __( 'Free Premium Trial', 'woocustomizer' ) ) . '</a>' . "\n";
            }
            $html             .= '<a href="' . esc_url( admin_url( 'admin.php?page=wcz_settings-affiliation' ) ) . '" class="wcz-acc-affiliate">' . esc_html( __( 'Become an Affiliate', 'woocustomizer' ) ) . '</a>' . "\n";
			// Contact is only for Premium users
			if ( wcz_fs()->can_use_premium_code() ) {
				$html             .= '<a href="' . esc_url( wcz_fs()->contact_url() ) . '" class="wcz-acc-contact">' . esc_html( __( 'Contact Us', 'woocustomizer' ) ) . '</a>' . "\n";
			}
		$html             .= '</div>' . "\n";
		$html             .= '<p>' . esc_html( __( 'Click here to open the WordPress Customizer and navigate to the -> StoreCustomizer panel.', 'woocustomizer' ) ) . '</p>' . "\n";
		$html             .= '<a href="' . esc_url( admin_url( 'customize.php' ) ) . '" class="wcz-customizer-btn">' . esc_html( __( 'Customize Your Settings', 'woocustomizer' ) ) . '</a>' . "\n";
		$html             .= '</div>' . "\n";
		$html             .= '</div>' . "\n";

		echo $html; //phpcs:ignore
	}

	/**
	 * Main WooCustomizer_Settings Instance
	 *
	 * Ensures only one instance of WooCustomizer_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WooCustomizer()
	 * @param object $parent Object instance.
	 * @return object WooCustomizer_Settings instance
	 */
	public static function instance( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Cloning of WooCustomizer_API is forbidden.' ) ), esc_attr( $this->parent->_version ) );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Unserializing instances of WooCustomizer_API is forbidden.' ) ), esc_attr( $this->parent->_version ) );
	} // End __wakeup()

}
