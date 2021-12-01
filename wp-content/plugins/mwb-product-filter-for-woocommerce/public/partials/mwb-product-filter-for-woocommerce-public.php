<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/public/partials
 */

$mwb_pf_loader_img_url = ( '' === get_option( 'mwb_pf_custom_loader', '' ) ) ? PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'public/src/loader_new.gif' : get_option( 'mwb_pf_custom_loader', '' );
?>
<div class="mwb-pffw-dialog-wrapper">
	<div class="mwb-pffw-dialog">   
		<div class="mwb-pffw-item">
			<img src="<?php echo esc_html( $mwb_pf_loader_img_url ); ?>" class="mwb-pffw-item-img">
			<div class="mwb-pffw-item-details"></div>
			<div class="mwb-pffw-action-buttons"></div>
		</div>
	</div>
</div>
