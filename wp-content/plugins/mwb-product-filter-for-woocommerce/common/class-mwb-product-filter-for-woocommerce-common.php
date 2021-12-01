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
class MWB_Product_Filter_For_Woocommerce_Common {


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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function pffw_common_enqueue_styles( $hook ) {

		wp_enqueue_style( $this->plugin_name, PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'common/src/scss/mwb-product-filter-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function pffw_common_enqueue_scripts( $hook ) {

		wp_register_script( $this->plugin_name . 'admin-js', PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'common/src/js/mwb-product-filter-for-woocommerce-common.js', array( 'jquery', 'mwb-pffw-select2', 'mwb-pffw-metarial-js', 'mwb-pffw-metarial-js2', 'mwb-pffw-metarial-lite' ), $this->version, false );
	}

	/**
	 * Filter_form_data
	 * public function for the filter to be created.
	 */
	public function filter_form_data() {

		check_ajax_referer( 'Form_data_nonce', 'nonce' );

		$data = array();
		$data = get_option( 'filter_data' );

		if ( isset( $_POST['action'] ) && isset( $_POST['filter_name'] ) ) {
			$filter_name = isset( $_POST['filter_name'] ) ? sanitize_text_field( wp_unslash( $_POST['filter_name'] ) ) : '';
			$taxonomies  = array();
			$taxonomies  = get_terms( wc_attribute_taxonomy_name( $filter_name ), 'orderby=name&hide_empty=0' );
			$taxonomy_terms[ $filter_name ] = $taxonomies;
			echo wp_json_encode( $taxonomies );
		}

		if ( isset( $_POST['action'] ) && isset( $_POST['title'] ) ) {
			$value  = array();
			$value  = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
			$result = array();
			if ( ! empty( $value ) ) {
				foreach ( $value as $key => $value ) {
					if ( 'action' !== $key && 'nonce' !== $key ) {
						$result[ $key ] = $value;
					}
				}
			}

			if ( empty( $data ) ) {

				$data[] = $result;

			} else {

				array_push( $data, $result );

			}
			sort( $data );
			update_option( 'filter_data', $data );
			echo wp_json_encode( 'Successful' );
		}
		if ( isset( $_POST['action'] ) && isset( $_POST['id_value'] ) && isset( $_POST['custom_fil_del'] ) && 'yes' !== $_POST['custom_fil_del'] ) {
			$id = '';
			$id = sanitize_text_field( wp_unslash( $_POST['id_value'] ) );
			if ( ! empty( $data ) ) {
				unset( $data[ $id ] );
				sort( $data );
				update_option( 'filter_data', $data );
				echo wp_json_encode( 'Deleted' );
			}
		} elseif ( 'yes' === $_POST['custom_fil_del'] ) {
			$id = '';
			$id = sanitize_text_field( wp_unslash( $_POST['id_value'] ) );
			$custom_fil_data = get_option( 'mwb_pff_custom_filters' );
			unset( $custom_fil_data[ $id ] );
			sort( $custom_fil_data );
			update_option( 'mwb_pff_custom_filters', $custom_fil_data );
			echo wp_json_encode( 'Deleted' );
		}
		wp_die();
	}

	// Class ends Here.
}
