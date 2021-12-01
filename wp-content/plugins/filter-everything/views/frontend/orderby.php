<?php
/**
 * The Template for displaying ordering dropdown.
 *
 * This template can be overridden by copying it to yourtheme/filter/orderby.php.
 *
 * @param string $action Form action URL
 * @param string $selected_orderby Currently selected value.
 * @param array $titles Possible titles.
 * @param array $orderbies Possible orderbies.
 * @param array $orders Possible orders.
 * @param array $meta_keys Possible meta keys.
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 * @since 1.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// @todo security and XSS esc_attr, sanitize attr
// @todo mark selected value
?>
<?php if( isset( $orderbies ) && ! empty( $orderbies ) ) : ?>
<form action="<?php echo esc_url( $action ); ?>" class="wpc-sorting-form" method="GET">
    <?php
        // 3rd party $_GET parameters
        flrt_query_string_form_fields(
            flrt_get_query_string_parameters(),
            ['ordr', 'orderby', 'product_orderby'] // Ignore these params
        );
    ?>

    <select name="ordr" class="wpc-orderby-select">
        <?php
            foreach( $orderbies as $i => $order_by_value ) :
                $title        = isset( $titles[$i] ) ? $titles[$i] : '';
                $option_value = flrt_sorting_option_value( $order_by_value, $meta_keys, $orders, $i );
            ?>
            <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $selected_orderby, $option_value ); ?>><?php echo esc_html( $title ); ?></option>
        <?php endforeach; ?>
    </select>
</form>
<div class="wpc-after-sorting-form"></div>
<?php endif; ?>