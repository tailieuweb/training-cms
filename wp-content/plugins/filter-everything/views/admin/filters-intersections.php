<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

?><table class="wpc-form-fields-table" id="wpc-intersections-table">
    <tr class="wpc-first-row">
        <?php if( ! empty( $fields ) ): ?>
            <?php

            $count = count( $fields );
            $rows  = intdiv( $count, 3 ) + 1;
            $i = 1;

            foreach( $fields as $key => $attributes ){ ?>
                <td class="wpc-filter-field-td"<?php
                    if( $count >= 5 && $i == 1 && isset( $fields['wp_entity'] ) ){
                        echo ' rowspan="'.$rows.'" ';
                    }
                ?>>
                    <?php echo flrt_render_input( $attributes ); ?>
                </td>
            <?php
                // Do not try to understand this code.
                // Just believe it works.
                $sep    = 4;
                $k      = $i;
                if( isset( $fields['wp_entity'] ) && $count >= 5 && ($i > 4) ){
                    $sep = 3;
                    $k = $i - 1;
                }
                if( ($k % $sep) === 0 ){
                    ?>
    </tr>
    <tr>
                    <?php
                }
                $i++;
            }  ?>

        <?php else: ?>

            <td class="wpc-filter-field-td">
                <span class="wpc-no-seo-filters-message"><?php echo esc_html__( 'Sorry. There is no filters active for SEO for selected post type', 'filter-everything' ); ?></span>
            </td>

        <?php endif; ?>
    </tr>
</table>