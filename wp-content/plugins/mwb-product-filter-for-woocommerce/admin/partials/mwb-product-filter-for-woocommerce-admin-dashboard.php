<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    MWB_Product_Filter_For_Woocommerce
 * @subpackage MWB_Product_Filter_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $pffw_mwb_pffw_obj, $error_notice;
$pffw_active_tab   = isset( $_GET['pffw_tab'] ) ? sanitize_key( $_GET['pffw_tab'] ) : 'product-filter-for-woocommerce-general';
$pffw_default_tabs = $pffw_mwb_pffw_obj->mwb_pffw_plug_default_tabs();

?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $pffw_mwb_pffw_obj->pffw_get_plugin_name() ) ) ); ?></h1>
		<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/mwb-product-filter-for-woocommerce/?utm_source=MWB-productfilter-org&utm_medium=MWB-backend-page&utm_campaign=MWB-productfilter-doc' ); ?>" class="mwb-link"><?php esc_html_e( 'Documentation', 'mwb-product-filter-for-woocommerce' ); ?></a>|
		<a href="<?php echo esc_url( 'https://makewebbetter.com/submit-query/?utm_source=MWB-productfilter-org&utm_medium=MWB-backend-page&utm_campaign=MWB-productfilter-support' ); ?>" class="mwb-link"><?php esc_html_e( 'Support', 'mwb-product-filter-for-woocommerce' ); ?></a>
	</div>
</header>
<?php
if ( ! $error_notice ) {
	$pffw_mwb_pffw_obj->mwb_pffw_plug_admin_notice( 'Settings saved !', 'success' );
}
?>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $pffw_default_tabs ) && ! empty( $pffw_default_tabs ) ) {

				foreach ( $pffw_default_tabs as $pffw_tab_key => $pffw_default_tabs ) {

					$pffw_tab_classes = 'mwb-link ';

					if ( ! empty( $pffw_active_tab ) && $pffw_active_tab === $pffw_tab_key ) {
						$pffw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $pffw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=product_filter_for_woocommerce_menu' ) . '&pffw_tab=' . esc_attr( $pffw_tab_key ) ); ?>" class="<?php echo esc_attr( $pffw_tab_classes ); ?>"><?php echo esc_html( $pffw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>

	<section class="mwb-section">
		<div>
			<?php
				do_action( 'mwb_pffw_before_general_settings_form' );
			// if submenu is directly clicked on woocommerce.
			if ( empty( $pffw_active_tab ) ) {
				$pffw_active_tab = 'mwb_pffw_plug_general';
			}

				// look for the path based on the tab id in the admin templates.
				$pffw_tab_content_path = 'admin/partials/' . $pffw_active_tab . '.php';

				$pffw_mwb_pffw_obj->mwb_pffw_plug_load_template( $pffw_tab_content_path );

				do_action( 'mwb_pffw_after_general_settings_form' );
			?>
		</div>
	</section>
