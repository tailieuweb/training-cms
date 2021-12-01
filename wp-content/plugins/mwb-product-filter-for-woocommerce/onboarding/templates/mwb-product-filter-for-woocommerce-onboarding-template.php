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

global $pffw_mwb_pffw_obj;
$pffw_onboarding_form_fields = apply_filters( 'mwb_pffw_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $pffw_onboarding_form_fields ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable mwb-pffw-on-boarding-dialog">
		<div class="mwb-pffw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-pffw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-pffw-on-boarding-close-btn">
						<a href="#"><span class="pffw-close-form material-icons mwb-pffw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-pffw-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'mwb-product-filter-for-woocommerce' ); ?> </h3>
					<p class="mwb-pffw-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'mwb-product-filter-for-woocommerce' ); ?></p>

					<form action="#" method="post" class="mwb-pffw-on-boarding-form">
						<?php
						$pffw_onboarding_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_onboarding_form_fields );
						echo esc_html( $pffw_onboarding_html );
						?>
						<div class="mwb-pffw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-pffw-on-boarding-form-submit mwb-pffw-on-boarding-form-verify ">
								<input type="submit" class="mwb-pffw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-pffw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-pffw-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'mwb-product-filter-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
