<?php
/**
 * The Template for displaying filter dropdown.
 *
 * This template can be overridden by copying it to yourtheme/filter/dropdown.php.
 *
 * $set - array, with the Filter Set parameters
 * $filter - array, with the Filter parameters
 * $url_manager - object, of the UrlManager PHP class
 * $terms - array, with objects of all filter terms except excluded
 * $noSelectUrl - string, URL for default option without selected term
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

$noSelectUrl = ( empty( $filter['values'] ) ) ? $url_manager->getResetUrl() : $url_manager->getTermUrl( reset( $filter['values'] ), $filter['e_name'] );

?>
<div class="<?php echo flrt_filter_class( $filter ); // Already escaped ?>" data-fid="<?php echo esc_attr( $filter['ID'] ); ?>">
    <?php flrt_filter_header( $filter, $terms ); // Safe, escaped ?>
    <div class="<?php echo esc_attr( flrt_filter_content_class( $filter ) ); ?>">
            <?php if( ! empty( $terms ) ): ?>
                    <select id="wpc-<?php echo esc_attr( $filter['entity'] ); ?>-<?php echo esc_attr( $filter['e_name'] ); ?>-<?php echo esc_attr( $filter['ID'] ); ?>" class="wpc-filters-widget-select">
                            <option class="wpc-dropdown-default" value="0" data-wpc-link="<?php echo esc_attr( $noSelectUrl ); ?>" id="wpc-option-<?php echo esc_attr( $filter['entity'] ); ?>-<?php echo esc_attr( $filter['e_name'] ); ?>-0"><?php
                                echo esc_html( sprintf( __( '- Select %s -', 'filter-everything' ), $filter['label'] ) );
                            ?></option><?php

                                foreach ( $terms as $id => $term_object ){
                                $selected = ( in_array( $term_object->slug, $filter['values'] ) ) ? 1 : 0;

                                    ?><option class="wpc-term-count-<?php echo esc_attr( $term_object->cross_count ); ?> wpc-term-id-<?php echo esc_attr($term_object->term_id); ?>" value="<?php echo esc_attr( $term_object->term_id ); ?>" <?php selected( 1, $selected ); ?> data-wpc-link="<?php echo esc_attr( $url_manager->getTermUrl( $term_object->slug, $filter['e_name'] ) ); ?>" id="wpc-option-<?php echo esc_attr( $filter['entity'] ); ?>-<?php echo esc_attr($filter['e_name']); ?>-<?php echo esc_attr( $id ); ?>"><?php
                                        echo esc_html( $term_object->name );

                                        if( $set['show_count']['value'] === 'yes' ) {
                                            echo esc_html( ' ('.$term_object->cross_count.')' );
                                        }
                                    ?></option>
                            <?php } ?><!-- end foreach -->
                    </select>
            <?php  else:

                    if( ! flrt_is_filter_request() ){
                        ?><p><?php esc_html_e('There are no terms yet', 'filter-everything' );

                        if( flrt_is_debug_mode() ){
                            echo '&nbsp;'.flrt_help_tip(
                                    esc_html__('Possible reasons: 1) Filter\'s criteria doesn\'t contain any terms yet and you have to add them 2) Terms may be created, but no one post that should be filtered attached to these terms 3) You excluded all possible terms in Filter\'s options.', 'filter-everything')
                                );
                        }
                    }else{
                        esc_html_e('N/A', 'filter-everything' );
                    }
                    ?></p>
            <?php endif; ?><!-- end if -->
    </div>
</div>