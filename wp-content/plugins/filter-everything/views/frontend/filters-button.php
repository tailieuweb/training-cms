<?php
/**
 * The Template for displaying Filters opening/closing button.
 *
 * This template can be overridden by copying it to yourtheme/filter/filters-button.php.
 *
 * $wpc_found_posts - int|NULL, found posts number
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

?>
<div class="wpc-filters-open-button-container wpc-open-button-<?php echo esc_attr( $set_id ); ?>">
    <a class="<?php echo esc_attr( $class ); ?>" href="javascript:void(0);" data-wid="<?php echo esc_attr( $set_id ); ?>"><span class="wpc-button-inner"><?php
            // Button icon
            flrt_get_icon_html();

            ?><span class="wpc-filters-button-text"><?php

            if( $wpc_found_posts !== NULL ){
                esc_html_e( sprintf( __('Filters %s', 'filter-everything'), '('.$wpc_found_posts.')' ) );
            } else {
                esc_html_e('Filters', 'filter-everything');
            }

            ?></span></span></a>
</div>