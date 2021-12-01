<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

$filterID           = isset( $filter['ID']['value'] ) ? $filter['ID']['value'] : 0;
$belongs_class      = ( $filter['entity']['entity_belongs'] ) ? 'wpc-belongs ' : 'wpc-belongs-not ';
$short_entity       = $filter['entity']['short_entity'];
$rowClass           = ( $filterID === \FilterEverything\Filter\FilterFields::FLRT_NEW_FILTER_ID ) ? 'wpc-filter-item wpc-new-filter-item' : 'wpc-filter-item';
?>
<div id="<?php echo esc_attr('wpc-filter-id-' . $filterID); ?>" class="wpc-filter-<?php echo esc_attr($filter['menu_order']['value']); ?> <?php echo esc_attr($belongs_class); ?><?php echo esc_attr($rowClass); ?>" data-fid="<?php echo esc_attr($filterID); ?>">
    <div class="wpc-filter-head">
        <div class="wpc-title-action widget-title-action">
            <button type="button" class="wpc-action widget-action hide-if-no-js" aria-expanded="false">
                <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
        </div>
        <div class="wpc-filter-title ui-sortable-handle">
            <ul class="wpc-custom-row wpc-filter-item-labels">
                <li class="wpc-filter-order"><span class="wpc-filter-sortable-handle"><?php echo esc_html( $filter['menu_order']['value'] ); ?></span></li>
                <li class="wpc-filter-label"><?php echo esc_html($filter['label']['value']); ?></li>
                <li class="wpc-filter-entity"><?php echo flrt_get_filter_entity_name( $filter['entity']['value'] ); // Already escaped in function ?></li>
                <li class="wpc-filter-view"><?php echo flrt_get_filter_view_name( $filter['view']['value'] ); // Already escaped in function ?></li>
                <li class="wpc-filter-slug"><?php echo esc_html( $filter['slug']['value'] ); ?></li>
            </ul>
        </div>
    </div>
    <div class="wpc-filter-body">
        <div class="wpc-additional-fields-selector"><a href="#" class="wpc-more-options-toggle"><?php esc_html_e('More options', 'filter-everything'); ?></a></div>
        <div class="wpc-filter-main-fields">
            <table class="wpc-form-fields-table wpc-filter-<?php echo esc_attr($short_entity); ?>">
                <tr class="wpc-filter-tr">
                    <td colspan="2">
                        <?php
                            $meta = flrt_extract_vars( $filter, array( 'ID', 'parent', 'menu_order' ) );
                            $_meta = $meta;
                            foreach ( $meta as $field_attributes ) {
                                echo flrt_render_input( $field_attributes ); // Safe, escaped
                            }
                        ?>
                    </td>
                </tr>
                <?php

                    $first_filters = flrt_extract_vars($filter, array('label', 'entity', 'instead-entity', 'e_name', 'slug', 'view') );

                    foreach( $first_filters as $field_key => $field_attributes ){

                        flrt_include_admin_view('filter-field', array(
                                'field_key'  => $field_key,
                                'attributes' =>  $field_attributes
                            )
                        );
                    }
                ?>
            </table>
            </div>

            <div class="wpc-filter-additional-fields">
                <table class="wpc-form-fields-table wpc-filter-<?php echo esc_attr($short_entity); ?>">
                <?php

                    foreach( $filter as $field_key => $field_attributes ){

                        flrt_include_admin_view('filter-field', array(
                            'field_key'  => $field_key,
                            'attributes' =>  $field_attributes
                            )
                        );
                    }

                ?>
                </table>
            </div>
        <div class="wpc-remove-filter-wrapper">
            <table class="wpc-form-fields-table">
                <tr class="wpc-filter-tr">
                    <td class="wpc-filter-label-td wpc-filter-delete-controls-td">
                        <div class="alignleft">
                            <span class="widget-control-close-wrapper"><button type="button" class="button-link wpc-done-action"><?php esc_html_e('Close', 'filter-everything'); ?></button> |
                                <button type="button" class="button-link button-link-delete wpc-button-link-delete"><?php esc_html_e('Delete', 'filter-everything'); ?></button>
                            </span>
                        </div>
                        <br class="clear" />
                    </td>
                    <td class="wpc-filter-field-td wpc-filter-delete-td">
                        <div class="alignright wpc-filter-delete-wrapper" id="wpc-filter-delete-wrapper-<?php echo esc_attr( $_meta['ID']['value'] ); ?>">
                            <span class="spinner"></span>
                            <input type="button" class="button wpc-filter-delete" data-fid="<?php echo esc_attr( $_meta['ID']['value'] ); ?>" value="<?php echo esc_attr( __('Delete, I\'m sure', 'filter-everything') ); ?>">
                            <input type="button" class="button right wpc-filter-delete-cancel" value="<?php echo esc_attr( __('Cancel', 'filter-everything') ); ?>">
                        </div>
                        <br class="clear" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>