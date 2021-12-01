<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

?><span class="wpc-container-handle-wrapper">
    <a href="javascript:void(0);" class="wpc-open-container button" data-field="<?php echo esc_attr( $field_id ); ?>"><?php
        esc_html_e( 'Insert variable', 'filter-everything' );
    ?></a>
    <?php do_action( 'wpc_after_seo_vars_button', $field_id, $field_html ); ?>
</span>
<?php echo $field_html; ?>
<div id="wpc-vars-container-<?php echo esc_attr( $field_id ); ?>" data-container="<?php echo esc_attr( $field_id ); ?>" class="wpc-vars-container">
    <ul class="wpc-seo-vars-list"></ul>
</div>