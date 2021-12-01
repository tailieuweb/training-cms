<?php

    if ( ! defined('WPINC') ) {
        wp_die();
    }

    $post_id    = $post->ID;
    $filters    = flrt_get_configured_filters( $post_id );

    $filterSet  = \FilterEverything\Filter\Container::instance()->getFilterSetService();

?>
<div class="wpc-filter-set-wrapper">
    <div class="wpc-filter-set-hidden-fields">
        <input type="hidden" id="wpc_set_nonce" name="_flrt_nonce" value="<?php echo esc_attr( flrt_create_filters_nonce() ); ?>" />
    </div>
    <div class="wpc-column-labels-wrapper">
        <table class="wpc-form-fields-table">
            <?php

            $attributes = $filterSet->getPostTypeField($post_id);
            $post_type  = ( isset( $attributes['post_type']['value'] ) && $attributes['post_type']['value'] ) ? $attributes['post_type']['value'] : $attributes['post_type']['default'];
            flrt_include_admin_view('filter-field', array(
                    'field_key'  => key($attributes),
                    'attributes' =>  reset($attributes)
                )
            );

            ?>
        </table>
    </div>
    <div class="wpc-column-labels-wrapper">
        <div class="wpc-column-labels widget-title">
            <ul class="wpc-custom-row">
                <li class="wpc-filter-order"><?php esc_html_e('#', 'filter-everything'); ?></li>
                <li class="wpc-filter-label"><?php esc_html_e('Label', 'filter-everything' ); ?></li>
                <li class="wpc-filter-entity"><?php esc_html_e('Filter by', 'filter-everything' ); ?></li>
                <li class="wpc-filter-view"><?php esc_html_e('View', 'filter-everything' ); ?></li>
                <li class="wpc-filter-slug"><?php esc_html_e('URL Prefix', 'filter-everything' ); ?></li>
            </ul>
        </div>
    </div>
    <div class="wpc-no-filters"<?php if( ! $filters ){ echo ' style="display: block;"'; }?>>
        <?php
            echo wp_kses(
                    __('No filters yet. Click the <strong>Add Filter</strong> button to create your first one.', 'filter-everything' ),
                    array( 'strong' => array() )
                );
            ?>
    </div>
    <div id="wpc-filters-list" class="wpc-filters-list" data-posttype="<?php echo $post_type; ?>">

        <?php if( $filters ):

                foreach( $filters as $filter ):

                    flrt_include_admin_view( 'filter-row', array( 'filter' => $filter ) );

                endforeach;

         endif; ?>
    </div>

    <div class="wpc-add-filter-wrapper">
        <div class="wpc-add-filter-div">
            <a href="#" class="button button-primary button-large wpc-add-filter"><?php esc_html_e('Add Filter','filter-everything' ); ?></a>
        </div>
    </div>

    <script type="text/html" id="wpc-new-filter">
        <?php
            flrt_include_admin_view( 'filter-row', array( 'filter' => flrt_get_empty_filter() ) );
        ?>
    </script>
</div>