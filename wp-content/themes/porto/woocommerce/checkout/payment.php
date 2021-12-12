<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">

	<?php if ( porto_checkout_version() == 'v2' ) : ?>
		<h3><?php esc_html_e( 'Payment methods', 'woocommerce' ); ?></h3>
	<?php endif; ?>

	<?php if ( WC()->cart->needs_payment() ) : ?>
		<div class="porto-separator m-b-md"><hr class="separator-line  align_center"></div>
		<h4 class="px-2"><?php esc_html_e( 'Payment methods', 'woocommerce' ); ?></h4>
		<ul class="wc_payment_methods payment_methods methods px-2">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'porto' ) : __( 'Please fill in your details above to see available payment methods.', 'porto' ) ) . '</li>'; // @codingStandardsIgnoreLine
			}
			?>
		</ul>
		<div class="porto-separator m-b-lg"><hr class="separator-line  align_center"></div>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php /* translators: $1 and $2 opening and closing emphasis tags respectively */ ?>
			<?php printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'porto' ), '<em>', '</em>' ); ?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'porto' ); ?>"><?php esc_html_e( 'Update totals', 'porto' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php if ( 'v2' == porto_checkout_version() ) : ?>

			<h3>
				<?php esc_html_e( 'Grand Total:', 'porto' ); ?>&nbsp;&nbsp;
				<span><?php wc_cart_totals_order_total_html(); ?></span>
			</h3>

		<?php endif; ?>

		<?php $img = PORTO_URI . '/images/ajax-loader.gif'; ?>
		<?php $img_2x = PORTO_URI . '/images/ajax-loader@2x.gif 2x'; ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt btn-v-dark w-100 mt-3 py-3" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">'. esc_html( $order_button_text ) .'</button><img src="' . $img . '" srcset="' . $img_2x . '" alt="loader"/>' ); // @codingStandardsIgnoreLine ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
