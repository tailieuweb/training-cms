<?php

/**
 * Validates whether the WC Cart instance is available in the request.
 *
 * @return bool
 */
function flatsome_is_wc_cart_available() {
	if ( ! function_exists( 'WC' ) ) return false;
	return WC() instanceof \WooCommerce && WC()->cart instanceof \WC_Cart;
}

