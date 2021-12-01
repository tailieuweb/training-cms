<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

$num = $i;

$title = ($title) ? $title : esc_html__( 'Item #', 'filter-everything' ) . $num;
$meta_key_class = '';
if( isset( $orderbiesSelect->attributes['value'] ) ){
    if( in_array( $orderbiesSelect->attributes['value'], ['m', 'n'] ) ){
        $meta_key_class = ' wpc-opened';
    }
}
?>
<div class="wpc-sorting-item-wrapper wpc-sorting-item-<?php echo $num; ?>">
    <div class="wpc-sorting-item-top">
        <div class="wpc-sorting-item-handle"><span class="dashicons dashicons-menu"></span></div>
        <div class="wpc-sorting-item-title" data-title="<?php esc_html_e( 'Item #', 'filter-everything' ); ?>"><?php echo esc_attr( $title ); ?></div>
        <div class="wpc-sorting-item-remove">×</div>
    </div>
    <div class="wpc-sorting-item-inside">
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'titles' ) . '-' . $i ); ?>"><?php esc_html_e( 'Title', 'filter-everything' ); ?></label>
            <input class="widefat wpc-sorting-item-label" id="<?php echo esc_attr( $widget->get_field_id( 'titles' ) . '-' . $i ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'titles' ) . '[]'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'orderbies' ) . '-' . $i ); ?>"><?php esc_html_e( 'Order By', 'filter-everything' ); ?></label>
            <?php echo $orderbiesSelect->render(); ?>
        </p>
        <p class="wpc-sorting-item-meta-key-wrapper<?php echo $meta_key_class; ?>">
            <label for="<?php echo esc_attr( $widget->get_field_id( 'meta_keys' ) . '-' . $i ); ?>"><?php esc_html_e( 'Meta key', 'filter-everything' ); ?></label>
            <input class="widefat wpc-sorting-item-meta-key" id="<?php echo esc_attr( $widget->get_field_id( 'meta_keys' ) . '-' . $i ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'meta_keys' ) . '[]'); ?>" type="text" value="<?php echo esc_attr( $metaKey ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $widget->get_field_id( 'orders' ) . '-' . $i ); ?>"><?php esc_html_e( 'Order', 'filter-everything' ); ?></label>
            <?php echo $ordersSelect->render(); ?>
        </p>
    </div>
</div>
