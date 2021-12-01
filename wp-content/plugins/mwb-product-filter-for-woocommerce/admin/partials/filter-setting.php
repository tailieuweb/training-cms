<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to make the filter settings.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$mwb_pf_custom_filter_array = get_option( 'mwb_pff_custom_filters', array() );
if ( isset( $_POST['mwb_pf_type'] ) && 'cus' === $_POST['mwb_pf_type'] && isset( $_POST['mwb_pffw_form_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_pffw_form_nonce'] ) ), 'form_nonce' ) ) {
	$mwb_pf_custom_filter_array[] = array(
		'title'    => ( isset( $_POST['title'] ) ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '',
		'fil_type' => ( isset( $_POST['mwb_pf_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['mwb_pf_type'] ) ) : '',
		'meta_key' => ( isset( $_POST['pffw_select_for_meta_filter'] ) ) ? sanitize_text_field( wp_unslash( $_POST['pffw_select_for_meta_filter'] ) ) : '',
		'meta_val' => ( isset( $_POST['mwb_pf_meta_val'] ) ) ? sanitize_text_field( wp_unslash( $_POST['mwb_pf_meta_val'] ) ) : '',
		'type'     => ( isset( $_POST['filter_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_type'] ) ) : '',
		'query'    => ( isset( $_POST['query_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['query_type'] ) ) : '',
	);
	update_option( 'mwb_pff_custom_filters', $mwb_pf_custom_filter_array );
}
?>
<div class="pff_filters_table">
	<table class='filter_table'>
		<tr>
			<th><?php esc_html_e( 'Filter Title', 'mwb-product-filter-for-woocommerce' ); ?></th>
			<th><?php esc_html_e( 'Filter Type', 'mwb-product-filter-for-woocommerce' ); ?></th>
			<th><?php esc_html_e( 'Query Type', 'mwb-product-filter-for-woocommerce' ); ?></th>
			<th><?php esc_html_e( 'Attribute/Meta Key/Meta Value', 'mwb-product-filter-for-woocommerce' ); ?></th>
			<th><?php esc_html_e( 'Operation', 'mwb-product-filter-for-woocommerce' ); ?></th>
		</tr>
	</table>
</div>
<div class="mdc-dialog mdc-dialog--scrollable">
	<div class="mwb-pffw-on-boarding-wrapper-background mdc-dialog__container">
		<div class="mwb-pffw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
			<div class="mdc-dialog__content">
				<div class="div-one-form">
					<div class="mwb-pffw-on-boarding-close-btn">
						<a href="#">
							<span class="pffw-close-form material-icons mwb-pffw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span>
						</a>
					</div>
					<form action="" method="post" id="filter_form" class="mwb-pffw-on-boarding-form" enctype="multipart/form-data">
						<?php
						global $pffw_mwb_pffw_obj;
						$pffw_filter_form = apply_filters( 'filter_adding_popoup', array() );
						?>
						<!-- filter_classes file for admin settings -->
						<?php
						$pffw_filter_form_html = $pffw_mwb_pffw_obj->mwb_pffw_plug_generate_html( $pffw_filter_form );
						echo esc_html( $pffw_filter_form_html );
						wp_nonce_field( 'form_nonce', 'mwb_pffw_form_nonce' );
						?>
					</form>
				</div>
				<div class="div-two-form">
					<div class="mwb-pffw-on-boarding-close-btn_message_message">
						<p class="message-div"></p>
						<p class="err-message-div"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mdc-dialog__scrim"></div>
	<div class="div-two-form">
		<div class="mwb-pffw-on-boarding-close-btn_message">
			<p class="message-div"></p>
			<p class="err-message-div"></p>
		</div>
	</div>
</div>
<?php
if ( ! empty( $mwb_pf_custom_filter_array ) ) {
	?>
	<div class="pff_filters_table-custom">
		<table class='filter_table-custom'>
			<?php
			foreach ( $mwb_pf_custom_filter_array as $key => $value ) {
				?>
			<tr>
				<td><?php echo esc_html( $value['title'] ); ?></td>
				<td><?php echo esc_html( $value['type'] ); ?></td>
				<td><?php echo esc_html( $value['query'] ); ?></td>
				<td><?php echo esc_html( $value['meta_key'] ) . '/' . esc_html( $value['meta_val'] ); ?></td>
				<td><a id="custom_fil" data-id="<?php echo esc_html( $key ); ?>" href="#" class="operation">Delete</a></td>
			</tr>
				<?php
			}
			?>
		</table>
	</div>
	<?php
}
?>
<div class="pff_add_filter_button ">
	<button class=" mdc-button mdc-button--raised mdc-ripple-upgraded filter_addition"><?php esc_html_e( 'Add Filter', 'mwb-product-filter-for-woocommerce' ); ?></button>
</div>
