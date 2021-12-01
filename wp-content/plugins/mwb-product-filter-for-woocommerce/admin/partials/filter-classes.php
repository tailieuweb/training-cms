<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to make the filter classes setting.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin/partials
 */

?>
<div class="mwb-pffw_success">
<span class="success_close">+</span>
<p><?php esc_html_e( 'Settings Saved !', 'mwb-product-filter-for-woocommerce' ); ?></p>
</div>
<?php
if ( isset( $_POST['class_form_nonce'] ) && isset( $_POST['pffw_default_values_reset'] ) ) {
	$class_nonce = sanitize_text_field( wp_unslash( $_POST['class_form_nonce'] ) );
	if ( wp_verify_nonce( $class_nonce, 'class-form-nonce' ) ) {
		unset( $_POST['pffw_default_values_reset'] );
		$pffw['product_container'] = '.products';
		$pffw['shop_pagination'] = 'nav.woocommerce-pagination';
		$pffw['result_count'] = '.woocommerce-result-count';
		$pffw['scroll_up_anchor'] = '.mwb_pffw_container';
		update_option( 'pffw_classes_names', $pffw );
	}
}
if ( isset( $_POST['class_form_nonce'] ) && isset( $_POST['pffw_save_filter_classes'] ) ) {
	$class_nonce = sanitize_text_field( wp_unslash( $_POST['class_form_nonce'] ) );
	if ( wp_verify_nonce( $class_nonce, 'class-form-nonce' ) ) {
		unset( $_POST['pffw_save_filter_classes'] );

		$pffw = array();
		$pffw['product_container'] = ! empty( $_POST['product_container'] ) ? sanitize_text_field( wp_unslash( $_POST['product_container'] ) ) : '';
		$pffw['shop_pagination']   = ! empty( $_POST['shop_pagination'] ) ? sanitize_text_field( wp_unslash( $_POST['shop_pagination'] ) ) : '';
		$pffw['result_count']      = ! empty( $_POST['result_count'] ) ? sanitize_text_field( wp_unslash( $_POST['result_count'] ) ) : '';
		$pffw['scroll_up_anchor']  = ! empty( $_POST['scroll_up_anchor'] ) ? sanitize_text_field( wp_unslash( $_POST['scroll_up_anchor'] ) ) : '';
		update_option( 'pffw_classes_names', $pffw );
	}
}
?>
<form class="pffw_class_listing" action="" method="POST">
	<input type="hidden" name="class_form_nonce" value="<?php echo esc_html( wp_create_nonce( 'class-form-nonce' ) ); ?>"/>
	<table class="form-table">
		<tbody>
			<?php
			global $pffw_mwb_pffw_obj;
			$pffw_filter_classes = apply_filters( 'mwb_pffw_filter_classes_html', array() );
			$pffw_filter_button_classes = apply_filters( 'mwb_pffw_filter_classes_button', array() );
			?>
			<!-- filter_classes file for admin settings -->
			<?php
			$pffw_filter_classes_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_filter_classes );
			?>
			<div class="button-wrapper-cutsom">
				<?php
				$pffw_filter_classes_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_filter_button_classes );
				?>
			</div>
		</tbody>
	</table>
</form>
