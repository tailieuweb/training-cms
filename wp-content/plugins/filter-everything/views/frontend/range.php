<?php
/**
 * The Template for displaying filter range.
 *
 * This template can be overridden by copying it to yourtheme/filter/range.php
 *
 * $filter - array, with the Filter parameters
 * $url_manager - object, of the UrlManager PHP class
 * $terms - array, with objects of all filter terms except excluded
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

?>
<div class="<?php echo flrt_filter_class( $filter ); // Already escaped?>" data-fid="<?php echo esc_attr( $filter['ID'] ); ?>">
    <?php flrt_filter_header( $filter, $terms ); // Safe, escaped ?>
    <div class="<?php echo esc_attr( flrt_filter_content_class( $filter ) ); ?>">
        <div class="wpc-filters-range-inputs">
            <?php if( ! empty( $terms ) ): ?>
                <?php

                    $minName = flrt_range_input_name( $filter['slug'] );
                    $maxName = flrt_range_input_name( $filter['slug'], 'max' );
                    $absMin = $absMax = 0;
                    $hasSliderClass = ( $filter['range_slider'] === 'yes' ) ? 'wpc-form-has-slider' : 'wpc-form-without-slider';

                    foreach( $terms as $term ){

                        foreach( $terms as $term ){
                            if( isset($term->min) ){
                                $absMin = $term->min;
                            }
                            if( isset( $term->max ) ){
                                $absMax = $term->max;
                            }
                        }
                    }

                    $max = isset( $filter['values']['max'] ) ? $filter['values']['max'] : $absMax;
                    $min = isset( $filter['values']['min'] ) ? $filter['values']['min'] : $absMin;
                ?>
                <form action="<?php echo esc_url( $url_manager->getFormActionUrl() ); ?>" method="GET" class="wpc-filter-range-form <?php echo esc_attr( $hasSliderClass ); ?>" id="wpc-filter-range-form-<?php echo esc_attr($filter['ID']); ?>">
                    <div class="wpc-filters-range-wrapper">
                        <div class="wpc-filters-range-column wpc-filters-range-min-column">
                            <?php // if there are value in $_GET we have to put it into field ?>
                            <?php // attr step should be configured in options ?>
                            <input type="number" class="wpc-filters-range-min" name="<?php echo esc_attr( $minName ); ?>" value="<?php echo esc_attr( $min ); ?>" step="<?php echo esc_attr( $filter['step'] ); ?>" data-min="<?php echo esc_attr( $absMin ); ?>" />
                        </div>
                        <div class="wpc-filters-range-column wpc-filters-range-max-column">
                            <input type="number" class="wpc-filters-range-max" name="<?php echo esc_attr( $maxName ); ?>" value="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $filter['step'] ); ?>" data-max="<?php echo esc_attr( $absMax ); ?>" />
                        </div>
                    </div>
                    <?php
                    /**
                     * @bug if $absMin === $absMax slider freezes
                     */
                    ?>
                    <?php if( $filter['range_slider'] === 'yes' ): ?>
                        <div class="wpc-filters-range-slider-wrapper">
                            <div class="wpc-filters-range-slider-control wpc-slider-control-<?php echo esc_attr( $filter['ID'] ); ?>" data-fid="<?php echo esc_attr( $filter['ID'] ); ?>"></div>
                        </div>
                    <?php else: ?>
                        <div class="wpc-filters-range-values-wrapper">
                            <p><?php echo esc_html( sprintf( __( '%s: %d &mdash; %d' ), $filter['label'], $absMin, $absMax ) ); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php

                        flrt_query_string_form_fields(
                                flrt_get_query_string_parameters(),
                                [$minName, $maxName]
                        );
                    ?>
                </form>

            <?php  else:  ?>

                <?php esc_html_e('There are no posts with such filtering criteria.', 'filter-everything' ); ?>

            <?php endif; ?><!-- end if -->
        </div>
    </div>
</div>

