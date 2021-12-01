<?php
/**
 * The Template for displaying filter labels.
 *
 * This template can be overridden by copying it to yourtheme/filter/labels.php.
 *
 * $set - array, with the Filter Set parameters
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
<div class="<?php echo flrt_filter_class( $filter ); // Already escaped ?>" data-fid="<?php echo esc_attr( $filter['ID'] ); ?>">
    <?php flrt_filter_header( $filter, $terms ); // Safe, escaped ?>
    <div class="<?php echo esc_attr( flrt_filter_content_class( $filter ) ); ?>">
        <?php if( $filter['search'] === 'yes' ):  ?>
            <div class="wpc-filter-search-wrapper wpc-filter-search-wrapper-<?php echo esc_attr( $filter['ID'] ); ?>">
                <input class="wpc-filter-search-field" type="text" value="" placeholder="<?php esc_html_e('Search', 'filter-everything' ) ?>" />
                <button class="wpc-search-clear" type="button" title="<?php esc_html_e('Clear search', 'filter-everything' ) ?>"><span class="wpc-search-clear-icon">&#215;</span></button>
            </div>
        <?php endif; ?>
        <ul class="wpc-filters-ul-list wpc-filters-labels wpc-filters-list-<?php echo esc_attr( $filter['ID'] ); ?>">
            <?php if( ! empty( $terms ) ): ?>

                <?php foreach ( $terms as $id => $term_object ){

                    $checked         = ( in_array( $term_object->slug, $filter['values'] ) ) ? 1 : 0;
                    $active_class    = $checked ? ' wpc-term-selected' : '';
                    $link            = $url_manager->getTermUrl( $term_object->slug, $filter['e_name'] );
                    $link_attributes = 'href="'.esc_url($link).'"';

                    ?>
                        <li class="wpc-label-item wpc-term-item<?php echo esc_attr( $active_class ); ?> wpc-term-count-<?php echo esc_attr( $term_object->cross_count ); ?> wpc-term-id-<?php echo esc_attr( $id ); ?>" id="<?php flrt_term_id('term', $filter, $id ); ?>">
                            <div class="wpc-term-item-content-wrapper">
                                <input class="wpc-label-input" <?php checked( 1, $checked ); ?> type="checkbox" data-wpc-link="<?php echo esc_url( $link ); ?>" id="<?php flrt_term_id('checkbox', $filter, $id); ?>" />
                                <label for="<?php flrt_term_id('checkbox', $filter, $id); ?>">
                                    <span class="wpc-filter-label-wrapper">
                                        <?php
                                        /**
                                         * Allow developers to change filter terms html
                                         */
                                        echo apply_filters( 'wpc_filters_label_term_html', '<a '.$link_attributes.'>'.$term_object->name.'</a>', $link_attributes, $term_object, $filter );

                                        ?>&nbsp;<?php flrt_count( $term_object, $set['show_count']['value'] ); // Safe, escaped?>
                                    </span>
                                </label>
                            </div>
                        </li>
                <?php } ?><!-- end foreach -->

            <?php  else:
                if( ! flrt_is_filter_request() ){
                    ?><li><?php esc_html_e('There are no terms yet', 'filter-everything' );
                        if( flrt_is_debug_mode() ){
                            echo '&nbsp;'.flrt_help_tip(
                                    esc_html__('Possible reasons: 1) Filter\'s criteria doesn\'t contain any terms yet and you have to add them 2) Terms may be created, but no one post that should be filtered attached to these terms 3) You excluded all possible terms in Filter\'s options.', 'filter-everything')
                                );
                        }
                    ?></li><?php
                }else{
                    esc_html_e('N/A', 'filter-everything' );
                }
            ?>
            <?php endif; ?><!-- end if -->
        </ul>
    </div>
</div>