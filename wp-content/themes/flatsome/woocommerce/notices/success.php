<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( fl_woocommerce_version_check( '3.9.0' ) ) :

	if ( ! $notices ) {
		return;
	}

	?>

	<?php foreach ( $notices as $notice ) : ?>
		<div class="woocommerce-message message-wrapper"<?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
			<div class="message-container container success-color medium-text-center">
				<?php echo get_flatsome_icon( 'icon-checkmark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo wc_kses_notice( $notice['notice'] ); ?>
				<?php if ( is_product() && get_theme_mod( 'cart_dropdown_show', 1 ) ) { ?>
					<span class="added-to-cart" data-timer=""></span>
				<?php } ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php

else : // Below 3.9.0.

	if ( ! $messages ) {
		return;
	}

	?>

	<?php foreach ( $messages as $message ) : ?>
		<div class="woocommerce-message message-wrapper" role="alert">
			<div class="message-container container success-color medium-text-center">
				<?php echo get_flatsome_icon( 'icon-checkmark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo wc_kses_notice( $message ); ?>
				<?php if ( is_product() && get_theme_mod( 'cart_dropdown_show', 1 ) ) { ?>
					<span class="added-to-cart" data-timer=""></span>
				<?php } ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php
endif;
