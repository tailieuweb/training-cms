<?php
/**
 * Provide a overview for the plugin
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
?>
<div class="pffw-overview__wrapper">
	<div class="pffw-overview__banner">
		<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/overview-banner.png' ); ?>" alt="Overview banner image">
	</div>
	<div class="pffw-overview__content">
		<div class="pffw-overview__content-description">
			<h2><?php echo esc_html_e( 'What is MWB Product Filter for WooCommerce?', 'mwb-product-filter-for-woocommerce' ); ?></h2>
			<p>
			<?php
			echo esc_html_e(
				'MWB Product Filter for WooCommerce is a custom filter plugin that allows you to enable filters in your WooCommerce store. Your store visitor can easily find the product they need using these filters. You can also place these product filters as convenient using the provided shortcodes. The benefit you will get along with this plugin includes letting you choose the design and layout of the filter for your frontend. The free product filter plugin uses your product (or service) attributes to let you apply the filters.',
				'mwb-product-filter-for-woocommerce'
			);
			?>
			</p>
			<h3><?php echo esc_html_e( 'With our MWB Product Filter for WooCommerce plugin you can:', 'mwb-product-filter-for-woocommerce' ); ?></h3>
			<ul class="pffw-overview__features">
				<li><?php echo esc_html_e( 'Add custom filters using product attributes.', 'mwb-product-filter-for-woocommerce' ); ?></li>
				<li><?php echo esc_html_e( 'Add a custom loading icon.', 'mwb-product-filter-for-woocommerce' ); ?></li>
				<li><?php echo esc_html_e( 'Add shortcodes for placement of filters.', 'mwb-product-filter-for-woocommerce' ); ?></li>
				<li><?php echo esc_html_e( 'Add appealing filter representations such as lists, checkbox, etc.', 'mwb-product-filter-for-woocommerce' ); ?></li>
			</ul>
		</div>
		<div class="pffw-overview__keywords">
			<div class="pffw-overview__keywords-item">
				<div class="pffw-overview__keywords-card">
					<div class="pffw-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/icons/Filter-Widget-for-5-Layouts.png' ); ?>" alt="Filter-Widget-for-5-Layouts">
					</div>
					<div class="pffw-overview__keywords-text">
						<h3 class="pffw-overview__keywords-heading"><?php echo esc_html_e( 'Filter Widget for 5 Layouts', 'mwb-product-filter-for-woocommerce' ); ?></h3>
						<p class="pffw-overview__keywords-description">
						<?php
						echo esc_html_e(
							'The MWB Product Filter for WooCommerce lets you add filters in the form of Lists, Labels, Colors (in square shape), dropdown, checkbox/ image. Therefore, you can add easy-to-use filters for your customers in the most appealing formats.',
							'mwb-product-filter-for-woocommerce'
						);
						?>
						</p>
					</div>
				</div>
			</div>
			<div class="pffw-overview__keywords-item">
				<div class="pffw-overview__keywords-card">
					<div class="pffw-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/icons/Reset-Button.png' ); ?>" alt="Reset-Button">
					</div>
					<div class="pffw-overview__keywords-text">
						<h3 class="pffw-overview__keywords-heading"><?php echo esc_html_e( 'Reset Button', 'mwb-product-filter-for-woocommerce' ); ?></h3>
						<p class="pffw-overview__keywords-description"><?php echo esc_html_e( 'The reset button lets your customer uncheck all the selected filters with just one click. Thus, this button increases the utility of your WooCommerce filters.', 'mwb-product-filter-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="pffw-overview__keywords-item">
				<div class="pffw-overview__keywords-card">
					<div class="pffw-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/icons/Toggle-Option.png' ); ?>" alt="Toggle-Option">
					</div>
					<div class="pffw-overview__keywords-text">
						<h3 class="pffw-overview__keywords-heading"><?php echo esc_html_e( 'Toggle Option', 'mwb-product-filter-for-woocommerce' ); ?></h3>
						<p class="pffw-overview__keywords-description"><?php echo esc_html_e( 'We provide toggle functionality to switch on the filters. This will improve the look and feel of your WooCommerce store besides making browsing easier.', 'mwb-product-filter-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="pffw-overview__keywords-item">
				<div class="pffw-overview__keywords-card">
					<div class="pffw-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/icons/Custom-Loader.png' ); ?>" alt="Custom-Loader">
					</div>
					<div class="pffw-overview__keywords-text">
						<h3 class="pffw-overview__keywords-heading"><?php echo esc_html_e( 'Custom Loader', 'mwb-product-filter-for-woocommerce' ); ?></h3>
						<p class="pffw-overview__keywords-description">
						<?php
						echo esc_html_e(
							'The plugin lets you use the icon of your choice on the loading screen. This becomes significant when you have a lot of products in your store and the waiting time is relatively more.',
							'mwb-product-filter-for-woocommerce'
						);
						?>
						</p>
					</div>
				</div>
			</div>
			<div class="pffw-overview__keywords-item">
				<div class="pffw-overview__keywords-card">
					<div class="pffw-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_FILTER_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/icons/Shortcode.png' ); ?>" alt="Shortcode">
					</div>
					<div class="pffw-overview__keywords-text">
						<h3 class="pffw-overview__keywords-heading"><?php echo esc_html_e( 'Shortcode', 'mwb-product-filter-for-woocommerce' ); ?></h3>
						<p class="pffw-overview__keywords-description">
						<?php
						echo esc_html_e(
							'Using the shortcodes that we provide in the plugin, you can ensure the placement of the product filters and the reset button as per your convenience.',
							'mwb-product-filter-for-woocommerce'
						);
						?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
