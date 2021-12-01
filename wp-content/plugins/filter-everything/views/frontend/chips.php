<?php
/**
 * The Template for displaying filter selected terms.
 *
 * This template can be overridden by copying it to yourtheme/filter/chips.php.
 *
 * $chips - array, with the Filter Set parameters
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

?>
<ul class="wpc-filter-chips-list wpc-filter-chips-<?php echo esc_attr( $setid ); ?><?php if( ! $chips ){echo ' wpc-empty-chips-container';} ?>" data-set="<?php echo esc_attr( $setid ); ?>">
<?php if( $chips ) : ?>
    <?php foreach( $chips as $chip ): ?>
    <li class="wpc-filter-chip <?php echo esc_attr( $chip['class'] ); ?>">
        <a href="<?php echo esc_url( $chip['link'] ); ?>" title="<?php if( $chip['name'] !== esc_html__('Reset all', 'filter-everything') ){ echo esc_attr( sprintf( __('Remove %s from results', 'filter-everything'), '&laquo;'.$chip['label'] .': '.$chip['name'].'&raquo;' ) ); } ?>">
            <span class="wpc-chip-content">
                <span class="wpc-filter-chip-name"><?php echo esc_html( $chip['name'] ); ?></span>
                <span class="wpc-chip-remove-icon">&#215;</span></a>
            </span>
    </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>