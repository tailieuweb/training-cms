<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin/onboarding
 */

global $pagenow, $pffw_mwb_pffw_obj;
if ( empty( $pagenow ) || 'plugins.php' != $pagenow ) {
	return false;
}

$pffw_onboarding_form_deactivate = apply_filters( 'mwb_pffw_deactivation_form_fields', array() );
?>
<?php if ( ! empty( $pffw_onboarding_form_deactivate ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable mwb-pffw-on-boarding-dialog">
		<div class="mwb-pffw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-pffw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-pffw-on-boarding-close-btn">
						<a href="#">
							<span class="pffw-close-form material-icons mwb-pffw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span>
						</a>
					</div>

					<h3 class="mwb-pffw-on-boarding-heading mdc-dialog__title"></h3>
					<p class="mwb-pffw-on-boarding-desc"><?php esc_html_e( 'May we have a little info about why you are deactivating?', 'mwb-product-filter-for-woocommerce' ); ?></p>
					<form action="#" method="post" class="mwb-pffw-on-boarding-form">
						<?php
						$pffw_onboarding_deactive_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_onboarding_form_deactivate );
						echo esc_html( $pffw_onboarding_deactive_html );
						?>
						<div class="mwb-pffw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-pffw-on-boarding-form-submit mwb-pffw-on-boarding-form-verify ">
								<input type="submit" class="mwb-pffw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-pffw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-pffw-deactivation-no_thanks mdc-button"><?php esc_html_e( 'Skip and Deactivate Now', 'mwb-product-filter-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
