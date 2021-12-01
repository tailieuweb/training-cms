<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $pffw_mwb_pffw_obj;
$pffw_default_status = $pffw_mwb_pffw_obj->mwb_pffw_plug_system_status();
$pffw_wordpress_details = is_array( $pffw_default_status['wp'] ) && ! empty( $pffw_default_status['wp'] ) ? $pffw_default_status['wp'] : array();
$pffw_php_details = is_array( $pffw_default_status['php'] ) && ! empty( $pffw_default_status['php'] ) ? $pffw_default_status['php'] : array();
?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $pffw_mwb_pffw_obj->pffw_get_plugin_name() ) ) ); ?></h1>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=product_filter_for_woocommerce_menu' ) . '&pffw_tab=' . esc_attr( 'product-filter-for-woocommerce-support' ) ); ?>" class="mwb-link"><?php esc_html_e( 'Support', 'mwb-product-filter-for-woocommerce' ); ?></a>
	</div>
</header>
<div class="mwb-pffw-table-wrap">
	<div class="mwb-col-wrap">
		<div id="mwb-pffw-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-pffw-table mdc-data-table__table mwb-table" id="mwb-pffw-wp">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Variables', 'mwb-product-filter-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Values', 'mwb-product-filter-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $pffw_wordpress_details ) && ! empty( $pffw_wordpress_details ) ) { ?>
							<?php foreach ( $pffw_wordpress_details as $wp_key => $wp_value ) { ?>
								<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
									<tr class="mdc-data-table__row">
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_key ); ?></td>
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_value ); ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="mwb-col-wrap">
		<div id="mwb-pffw-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-pffw-table mdc-data-table__table mwb-table" id="mwb-pffw-sys">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Variables', 'mwb-product-filter-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Values', 'mwb-product-filter-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $pffw_php_details ) && ! empty( $pffw_php_details ) ) { ?>
							<?php foreach ( $pffw_php_details as $php_key => $php_value ) { ?>
								<tr class="mdc-data-table__row">
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_key ); ?></td>
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_value ); ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
