<?php

    if ( ! defined('WPINC') ) {
        wp_die();
    }

    $fields     = flrt_get_seo_rules_fields( $post->ID );
    $post_type  = flrt_extract_vars($fields, array('rule_post_type') );
    $postType   = reset( $post_type );
    $seo_fields = flrt_extract_vars( $fields, array( 'rule_seo_title', 'rule_meta_desc', 'rule_h1', 'rule_description') );
?>

<div class="wpc-filters-seo-rules-wrapper">
    <div class="wpc-filter-set-hidden-fields">
        <input type="hidden" id="wpc_seo_rule_nonce" name="_flrt_nonce" value="<?php echo esc_attr( flrt_create_seo_rules_nonce() ); ?>" />
    </div>
    <div class="wpc-column-labels-wrapper">
        <table class="wpc-form-fields-table">
            <tr id="wpc-rule-post-type">
                <td class="wpc-filter-label-td">
                    <label for="<?php echo esc_attr( $postType['id'] ); ?>" class="wpc-filter-label">
                        <?php esc_html_e('Post Type', 'filter-everything'); ?>
                    </label>
                    <p class="wpc-field-description"><?php esc_html_e('Select Post Type for SEO Rule', 'filter-everything'); ?></p>
                </td>
                <td class="wpc-filter-field-td">
                    <?php echo flrt_render_input( $postType ); //Safe, escaped inside ?>
                </td>
            </tr>
            <tr class="wpc-filter-intersection-tr">
                <td class="wpc-filter-label-td">
                    <label class="wpc-filter-label">
                        <?php esc_html_e('Filters Combination', 'filter-everything'); ?>
                    </label>
                    <p class="wpc-field-description"><?php esc_html_e('Specify filter or filters combination for which you need to set SEO data', 'filter-everything'); ?></p>
                    <?php echo flrt_help_tip(
                            wp_kses(
                                    __('For example you need to set SEO data for the page with URL path:<br />/color-blue/size-large/<br />For this purpose you have to select filters «Color» and «Size» only.<br />If you want to create common template for all color and size values, please chose<br />«Any Color» and «Any Size». If you need to set SEO data for specific Color and Size, please chose specific values like «Blue» and «Large».', 'filter-everything'),
                                    array('br' => array() )
                            ), true ); ?>
                </td>
                <td class="wpc-filter-field-td">
                    <div class="wpc-intersection-fields-wrapper" id="wpc-intersection-fields-container">
                        <span class="spinner"></span>
                        <?php
                            flrt_include_admin_view('filters-intersections', array(
                                    'fields'  => $fields
                                )
                            );
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr />
                </td>
            </tr>
            <?php foreach ( $seo_fields as $key => $attributes ): ?>
                <tr class="wpc-filter-tr <?php echo esc_attr( $attributes['class'] ); ?>-tr">
                    <td class="wpc-filter-label-td">
                        <label for="<?php echo esc_attr( $attributes['id'] ); ?>" class="wpc-filter-label">
                            <?php echo esc_html( $attributes['label'] ); ?>
                        </label>
                        <?php echo flrt_field_instructions($attributes); // Already escaped in function ?>
                        <?php echo flrt_tooltip($attributes); ?>
                    </td>
                    <td class="wpc-filter-field-td">
                        <div class="wpc-field-wrap <?php echo esc_attr( $attributes['id'] ); ?>-wrap">
                            <?php echo flrt_render_input( $attributes ); ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>