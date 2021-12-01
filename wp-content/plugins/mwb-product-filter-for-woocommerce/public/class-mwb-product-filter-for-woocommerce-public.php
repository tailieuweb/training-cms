<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace MWB_Product_Filter_For_Woocommerce_Public.
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class MWB_Product_Filter_For_Woocommerce_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function pffw_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/mwb-product-filter-for-woocommerce-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'jquery-ui-min-css', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/jquery-ui.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function pffw_public_enqueue_scripts() {
		wp_register_script( $this->plugin_name, PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/mwb-product-filter-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'pffw_public_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'filter_data_nonce' ),
				'mwb_pf_currency_symbol' => get_woocommerce_currency_symbol(),
			)
		);
		$classes = get_option( 'pffw_classes_names' );
		$filter_value = empty( get_option( 'filter_data' ) ) ? '' : get_option( 'filter_data' );
		if ( ! empty( $filter_value ) ) {
			$attribute_term = array();
			$attr_term = array();
			foreach ( $filter_value as $key => $value ) {
				$attribute_term[ $key ] = get_terms( wc_attribute_taxonomy_name( $value['attribute'] ), 'orderby=name&hide_empty=0' );
				$taxonomy_terms[ $value['attribute'] ] = $attribute_term[ $key ];

				if ( ! in_array( $value['attribute'], $attr_term, true ) ) {
					$attr_term[ $value['attribute'] ] = get_terms( wc_attribute_taxonomy_name( $value['attribute'] ), 'orderby=name&hide_empty=0' );
					$taxonomy_terms[ $value['attribute'] ] = $attr_term[ $value['attribute'] ];
				}
			}
		}
		wp_localize_script(
			$this->plugin_name,
			'mwb_pffw_classes',
			array(
				'label_for_link' => __( 'Show only instock item', 'mwb-product-filter-for-woocommerce' ),
				'classnames' => $classes,
				'filters'    => $filter_value,
				'attr_term'  => ( empty( $attribute_term ) ? '' : $attribute_term ),
				'attribute_terms' => ( empty( $attr_term ) ? '' : $attr_term ),
				'mwb_pf_filter_type' => get_option( 'mwb_pf_select_filter_type', 'mwb_pf_default_highlightfilter' ),
			)
		);
		wp_enqueue_script( $this->plugin_name );

		wp_enqueue_script( 'jquery-ui-min', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register_filter_shortcode
	 * Register Shortcode here.
	 */
	public function register_filter_shortcode() {

		add_shortcode( 'product_filter_for_woo', array( $this, 'product_filter_function' ) );
	}

	/**
	 * Product_filter_function
	 * Render the enabled fields.
	 *
	 * @since    1.0.0
	 */
	public function product_filter_function() {
		if ( is_shop() ) {
			$value = get_option( 'pffw_enable_product_filter', '' );
			if ( 'on' === $value ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/mwb-product-filter-for-woocommerce-public-display.php';
			}
		}
	}

	/**
	 * Custom_loader_function
	 * public function for the filter to be created.
	 */
	public function custom_loader_function() {
		$value = get_option( 'pffw_enable_product_filter', '' );
		if ( 'on' === $value ) {
			add_action( 'wp_footer', array( $this, 'render_pffw_html' ) );
		}
	}

	/**
	 * Render_pffw_html
	 * public function for the filter to be created.
	 */
	public function render_pffw_html() {
		wc_get_template(
			'partials/mwb-product-filter-for-woocommerce-public.php',
			array(),
			'',
			plugin_dir_path( __FILE__ )
		);
	}

	/**
	 * Function to add reset button shortcode.
	 *
	 * @return void
	 */
	public function mwb_pf_add_reset_button_shortcode() {
		add_shortcode( 'mwb_pf_reset_button', array( $this, 'mwb_pf_reset_button_shortcode' ) );
	}

	/**
	 * Function containing reset button HTML.
	 *
	 * @return string
	 */
	public function mwb_pf_reset_button_shortcode() {
		ob_start();
		$val = wc_get_page_permalink( 'shop' );
		?>
			<div class="pf-complete">
				<a href="<?php echo esc_html( $val ); ?>"><button type="submit" class="pf-reset_button"><?php esc_html_e( 'Reset Filters', 'mwb-product-filter-for-woocommerce' ); ?></button></a>
				<ul class="mwb_pf_separate_filter">

				</ul>
			</div>
		<?php
		return ob_get_clean();
	}


	/**
	 * Function to put reset button before shop loop.
	 *
	 * @return void
	 */
	public function mwb_pf_reset_button_before_shop_loop() {
		echo ( '1' === get_option( 'mwb_pf_select_reset_button_pos' ) ) ? do_shortcode( '[mwb_pf_reset_button]' ) : '';
	}


	/**
	 * Function to show only sale products.
	 *
	 * @param object $query string return by the hook.
	 * @return void
	 */
	public function mwb_product_filter_query( $query ) {

		$query->set(
			'meta_query',
			array(
				array(
					'key' => '_stock_status',
					'value' => 'instock',
				),
				array(
					'key' => '_backorders',
					'value' => 'no',
				),
			)
		);

	}

	/**
	 * Function to add action for instock products.
	 *
	 * @return void
	 */
	public function mwb_pffw_show_instock_items() {
		if ( isset( $_GET['mwb_show_only_items'] ) && 'instock' === $_GET['mwb_show_only_items'] ) {
			add_action( 'woocommerce_product_query', array( $this, 'mwb_product_filter_query' ) );
		}
	}

	/**
	 * Function to filter product as per the data
	 *
	 * @param array $query Query to be changed.
	 * @return void
	 */
	public function university_adjust_queries( $query ) {
		if ( isset( $_GET['mwb_filter_key'] ) && isset( $_GET['mwb_filter_val'] ) ) {
			$query->set(
				'meta_query',
				array(
					'relation' => ( isset( $_GET['mwb_filter_relation'] ) ) ? sanitize_text_field( wp_unslash( $_GET['mwb_filter_relation'] ) ) : '',
					array(
						'key'   => ( isset( $_GET['mwb_filter_key'] ) ) ? sanitize_text_field( wp_unslash( $_GET['mwb_filter_key'] ) ) : '',
						'value' => ( isset( $_GET['mwb_filter_val'] ) ) ? sanitize_text_field( wp_unslash( $_GET['mwb_filter_val'] ) ) : '',
					),
				)
			);
		}
	}
}
