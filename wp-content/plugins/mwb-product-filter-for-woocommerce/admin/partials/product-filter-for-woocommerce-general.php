<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin/partials
 */

?>
<div class="mwb-pffw_success-general">
<span class="success_close">+</span>
<p><?php esc_html_e( 'Shortcode Copied !', 'mwb-product-filter-for-woocommerce' ); ?></p>
</div>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $pffw_mwb_pffw_obj;
$pffw_genaral_settings = apply_filters( 'pffw_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-pffw-gen-section-form">
<input type="hidden" name="general_nonce" value="<?php echo esc_html( wp_create_nonce( 'general-form-nonce' ) ); ?>"/>
	<div class="pffw-secion-wrap">
		<?php
		$pffw_general_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_genaral_settings );
		echo esc_html( $pffw_general_html );
		?>
	</div>
</form>
