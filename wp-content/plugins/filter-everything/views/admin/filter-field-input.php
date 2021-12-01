<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

?><td class="wpc-filter-field-td">
    <div class="wpc-field-wrap <?php if( isset( $attributes['id'] ) ){ echo esc_attr( $attributes['id'] ); } ?>-wrap">
        <?php echo flrt_render_input( $attributes ); // Already escaped in function ?>
        <?php do_action('wpc_after_filter_input', $attributes ); ?>
    </div>
</td>