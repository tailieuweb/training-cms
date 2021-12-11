<?php

	class YIKES_Custom_Product_Tabs_Support {

		/**
		* Constructah >:^)
		*/
		public function __construct() {

			// Add our custom settings page
			add_action( 'admin_menu', array( $this, 'register_support_subpage' ), 20 );

			// Enqueue scripts & styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10, 1 );

			// Add our free support page HTML
			add_action( 'yikes-woo-support-page-free', array( $this, 'render_support_page' ), 100 );
		}

		/**
		* Enqueue our scripts and styes
		*
		* @param string | $page | The slug of the page we're currently on
		*/
		public function enqueue_scripts( $page ) {

			if ( $page === 'custom-product-tabs_page_' . YIKES_Custom_Product_Tabs_Support_Page ) {

				wp_enqueue_style( 'repeatable-custom-tabs-styles' , YIKES_Custom_Product_Tabs_URI . 'css/repeatable-custom-tabs.min.css', '', YIKES_Custom_Product_Tabs_Version, 'all' );
			}
		}

		/**
		* Register our settings page
		*/
		public function register_support_subpage() {

			// Add our custom settings page
			add_submenu_page(
				YIKES_Custom_Product_Tabs_Settings_Page,                            // Parent menu item slug
				__( 'Support', YIKES_Custom_Product_Tabs_Settings_Page ),           // Tab title name (HTML title)
				__( 'Support', YIKES_Custom_Product_Tabs_Settings_Page ),           // Menu page name
				apply_filters( 'yikes-woo-support-capability', 'publish_products' ),  // Capability required
				YIKES_Custom_Product_Tabs_Support_Page,                             // Page slug (?page=slug-name)
				array( $this, 'support_page' )                                      // Function to generate page
			);
		}

		/**
		* Include our settings page
		*/
		public function support_page() {

			require_once YIKES_Custom_Product_Tabs_Path . 'admin/page.support.php';
		}

		/**
		* Show our support page HTML
		*/
		public function render_support_page() { 
			if ( defined( 'YIKES_Custom_Product_Tabs_Pro_Enabled' ) ) {
				return;
			}
			?>
				<div class="cptpro-settings cptpro-settings-support-help-container">
					<p>
						<?php 
							echo sprintf( __( 'Before submitting a support request, please visit our %1sKnowledge Base%2s where we have step-by-step guides and troubleshooting help.', 'yikes-inc-easy-custom-woocommerce-product-tabs'  ), 
								'<a href="https://yikesplugins.com/support/knowledge-base/product/easy-custom-product-tabs-for-woocommerce/" target="_blank">', '</a>' ); 
						?>
					</p>

					<p>
						<?php 
							echo sprintf( __( 'Custom Product Tabs Pro users qualify for premium support. Check out %1sCustom Product Tabs Pro%2s!', 'yikes-inc-easy-custom-woocommerce-product-tabs'  ), 
								'<a href="https://yikesplugins.com/plugin/custom-product-tabs-pro/" target="_blank">', '</a>' ); 
						?>
					</p>

					<hr />					


					<h1>
						<span class="dashicons dashicons-wordpress-alt"></span> <?php _e( 'WordPress.org Support Forums', 'yikes-inc-easy-custom-woocommerce-product-tabs' ); ?>
					</h1>

					<p>
						<?php 
							echo sprintf( __( 'If you need help with free Custom Product Tabs, please post questions to %1sour support forum on the WordPress Plugin Directory%2s. We aim to respond to support requests within a week.', 'yikes-inc-easy-custom-woocommerce-product-tabs'  ), 
								'<a href="https://wordpress.org/support/plugin/yikes-inc-easy-custom-woocommerce-product-tabs#new-post" target="_blank">', '</a>' ); 
						?>
					</p>

					<p>
						<a class="button button-primary" href="https://wordpress.org/support/plugin/yikes-inc-easy-custom-woocommerce-product-tabs#new-post" target="_blank">
							<?php _e( 'Submit a Support Request', 'yikes-inc-easy-custom-woocommerce-product-tabs' ); ?>
						</a>
					</p>

					<a href="https://wordpress.org/support/plugin/yikes-inc-easy-custom-woocommerce-product-tabs#new-post" target="_blank">
						<img src="<?php echo YIKES_Custom_Product_Tabs_URI . 'images/support-screenshot.png' ?>" />
					</a>

				</div>
			<?php
		}

		
	}

	new YIKES_Custom_Product_Tabs_Support();