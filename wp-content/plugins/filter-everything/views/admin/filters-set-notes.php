<?php

    if ( ! defined('WPINC') ) {
        wp_die();
    }

?>
<p><strong><?php esc_html_e( 'WordPress', 'filter-everything' ); ?>:</strong></p>
<table class="wpc-notes-table"><?php
    printf( '<tr><th>_thumbnail_id</th><td>%s</td></tr>', esc_html__( 'filter by Featured Image (Custom Field Exists)', 'filter-everything' ) );
    ?>
</table>
<p><strong><?php esc_html_e( 'WooCommerce', 'filter-everything' ); ?>:</strong></p>
<table class="wpc-notes-table">
    <?php
    printf( '<tr><th>_price</th><td>%s</td></tr>', esc_html__( 'filter by Product price (Custom Field Num)', 'filter-everything' ) );
    printf( '<tr><th>_stock_status</th><td>%s</td></tr>', esc_html__( 'filter by Product Stock status (Custom Field)', 'filter-everything' ) );
    printf( '<tr><th>_sale_price</th><td>%s</td></tr>', esc_html__( 'by Sale Price (Custom Field Num) or on Sale Status (Custom Field Exists)', 'filter-everything' ) );
    printf( '<tr><th>total_sales</th><td>%s</td></tr>', esc_html__( 'by Sales Count', 'filter-everything' ) );
    printf( '<tr><th>_backorders</th><td>%s</td></tr>', esc_html__( 'by Backorders Status (Custom Field)', 'filter-everything' ) );
    printf( '<tr><th>_downloadable</th><td>%s</td></tr>', esc_html__( 'by Downloadable Status (Custom Field)', 'filter-everything' ) );
    printf( '<tr><th>_sold_individually</th><td>%s</td></tr>', esc_html__( 'by Sold Individually status (Custom Field)', 'filter-everything' ) );
    printf( '<tr><th>_stock</th><td>%s</td></tr>', esc_html__( 'by Stock Quantity (Custom Field Num)', 'filter-everything' ) );
    printf( '<tr><th>_virtual</th><td>%s</td></tr>', esc_html__( 'by Product Virtual status (Custom Field)', 'filter-everything' ) );
    printf( '<tr><th>_length</th><td>%s</td></tr>', esc_html__( 'by product Length', 'filter-everything' ) );
    printf( '<tr><th>_width</th><td>%s</td></tr>', esc_html__( 'by product Width', 'filter-everything' ) );
    printf( '<tr><th>_height</th><td>%s</td></tr>', esc_html__( 'by product Height', 'filter-everything' ) );
    printf( '<tr><th>_weight</th><td>%s</td></tr>', esc_html__( 'by product Weight', 'filter-everything' ) );
    echo wp_kses (
        sprintf(
            __( '<tr><th>_wc_average_rating</th><td>filter by Product Average Rating. Optionally use <a href="%s" target="_blank">Product Visibility</a> taxonomy instead</td></tr>', 'filter-everything' ),
            'https://demo.filtereverything.pro/example/by-rating/'
        ),
        array(
            'a' => array( 'href' => true, 'target' => true ),
            'tr' => array(),
            'th' => array(),
            'td' => array()
        )
    );
    ?>
</table>