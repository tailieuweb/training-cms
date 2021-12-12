<?php

// Porto Product Category
add_shortcode( 'porto_product_category', 'porto_shortcode_product_category' );
add_action( 'vc_after_init', 'porto_load_product_category_shortcode' );

function porto_shortcode_product_category( $atts, $content = null ) {
	ob_start();
	if ( $template = porto_shortcode_woo_template( 'porto_products' ) ) {
		$atts['shortcode'] = 'product_category';
		include $template;
	}
	return ob_get_clean();
}

function porto_load_product_category_shortcode() {
	$animation_type     = porto_vc_animation_type();
	$animation_duration = porto_vc_animation_duration();
	$animation_delay    = porto_vc_animation_delay();
	$custom_class       = porto_vc_custom_class();
	$order_by_values    = porto_vc_woo_order_by();
	$order_way_values   = porto_vc_woo_order_way();

	// woocommerce product category
	vc_map(
		array(
			'name'        => 'Porto ' . __( 'Product category', 'js_composer' ),
			'base'        => 'porto_product_category',
			'icon'        => 'fas fa-cart-arrow-down',
			'category'    => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show multiple products in a category', 'js_composer' ),
			'params'      => array_merge(
				array(
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Title', 'woocommerce' ),
						'param_name'  => 'title',
						'admin_label' => true,
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Title Border Style', 'porto-functionality' ),
						'param_name' => 'title_border_style',
						'dependency' => array(
							'element'   => 'title',
							'not_empty' => true,
						),
						'std'        => '',
						'value'      => array(
							__( 'No Border', 'porto-functionality' )     => '',
							__( 'Bottom Border', 'porto-functionality' ) => 'border-bottom',
							__( 'Middle Border', 'porto-functionality' ) => 'border-middle',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Title Align', 'porto-functionality' ),
						'param_name' => 'title_align',
						'value'      => porto_sh_commons( 'align' ),
						'dependency' => array(
							'element'   => 'title',
							'not_empty' => true,
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'View mode', 'porto-functionality' ),
						'param_name'  => 'view',
						'value'       => porto_sh_commons( 'products_view_mode' ),
						'admin_label' => true,
					),
					array(
						'type'       => 'porto_image_select',
						'heading'    => __( 'Grid Layout', 'porto-functionality' ),
						'param_name' => 'grid_layout',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'creative' ),
						),
						'std'        => '1',
						'value'      => porto_sh_commons( 'masonry_layouts' ),
					),
					array(
						'type'       => 'number',
						'heading'    => __( 'Grid Height (px)', 'porto-functionality' ),
						'param_name' => 'grid_height',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'creative' ),
						),
						'suffix'     => 'px',
						'std'        => 600,
					),
					array(
						'type'        => 'number',
						'heading'     => __( 'Column Spacing (px)', 'porto-functionality' ),
						'description' => __( 'Leave blank if you use theme default value.', 'porto-functionality' ),
						'param_name'  => 'spacing',
						'dependency'  => array(
							'element' => 'view',
							'value'   => array( 'grid', 'creative', 'products-slider' ),
						),
						'suffix'      => 'px',
						'std'         => '',
					),
					array(
						'type'        => 'number',
						'heading'     => __( 'Per page', 'js_composer' ),
						'value'       => 12,
						'param_name'  => 'per_page',
						'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
						'suffix'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Columns', 'porto-functionality' ),
						'param_name' => 'columns',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'products-slider', 'grid', 'divider' ),
						),
						'std'        => '4',
						'value'      => porto_sh_commons( 'products_columns' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Columns on mobile ( <= 575px )', 'porto-functionality' ),
						'param_name' => 'columns_mobile',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'products-slider', 'grid', 'divider' ),
						),
						'std'        => '',
						'value'      => array(
							__( 'Default', 'porto-functionality' ) => '',
							'1' => '1',
							'2' => '2',
							'3' => '3',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Column Width', 'porto-functionality' ),
						'param_name' => 'column_width',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'products-slider', 'grid', 'divider' ),
						),
						'value'      => porto_sh_commons( 'products_column_width' ),
					),
					array(
						'type'       => 'porto_multiselect',
						'heading'    => __( 'Show Sort by', 'porto-functionality' ),
						'param_name' => 'show_sort',
						'value'      => array(
							__( 'All', 'porto-functionality' ) => 'all',
							__( 'Popular', 'porto-functionality' ) => 'popular',
							__( 'Date', 'porto-functionality' ) => 'date',
							__( 'Rating', 'porto-functionality' ) => 'rating',
						),
						'std'        => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Title for "Sort by Popular"', 'porto-functionality' ),
						'param_name' => 'show_sales_title',
						'dependency' => array(
							'element' => 'show_sort',
							'value'   => 'popular',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Title for "Sort by Date"', 'porto-functionality' ),
						'param_name' => 'show_new_title',
						'dependency' => array(
							'element' => 'show_sort',
							'value'   => 'date',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Title for "Sort by Rating"', 'porto-functionality' ),
						'param_name' => 'show_rating_title',
						'dependency' => array(
							'element' => 'show_sort',
							'value'   => 'rating',
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Show sub category filter', 'porto-functionality' ),
						'param_name'  => 'category_filter',
						'std'         => 'no',
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Filter Style', 'porto-functionality' ),
						'param_name'  => 'filter_style',
						'value'       => array(
							__( 'Vertical', 'porto-functionality' )   => '',
							__( 'Horizontal', 'porto-functionality' ) => 'horizontal',
						),
						'description' => __( 'This field is used only when using "sort by" or "category filter".', 'porto-functionality' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Order by', 'js_composer' ),
						'param_name'  => 'orderby',
						'value'       => $order_by_values,
						/* translators: %s: Wordpress codex page */
						'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Order way', 'js_composer' ),
						'param_name'  => 'order',
						'value'       => $order_way_values,
						/* translators: %s: Wordpress codex page */
						'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Category', 'js_composer' ),
						'param_name'  => 'category',
						'description' => __( 'Please input category ID or slug.', 'porto-functionality' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Product Layout', 'porto-functionality' ),
						'description' => __( 'Select position of add to cart, add to wishlist, quickview.', 'porto-functionality' ),
						'param_name'  => 'addlinks_pos',
						'value'       => porto_sh_commons( 'products_addlinks_pos' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Use simple layout?', 'porto-functionality' ),
						'description' => __( 'If you check this option, it will display product title and price only.', 'porto-functionality' ),
						'param_name'  => 'use_simple',
						'std'         => 'no',
					),
					array(
						'type'       => 'number',
						'heading'    => __( 'Overlay Background Opacity (%)', 'porto-functionality' ),
						'param_name' => 'overlay_bg_opacity',
						'dependency' => array(
							'element' => 'addlinks_pos',
							'value'   => array( 'onimage2', 'onimage3' ),
						),
						'suffix'     => '%',
						'std'        => '30',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Image Size', 'porto-functionality' ),
						'param_name' => 'image_size',
						'dependency' => array(
							'element' => 'view',
							'value'   => array( 'products-slider', 'grid', 'divider', 'list' ),
						),
						'value'      => porto_sh_commons( 'image_sizes' ),
						'std'        => '',
					),
					$custom_class,
				),
				porto_vc_product_slider_fields(),
				array(
					$animation_type,
					$animation_duration,
					$animation_delay,
				)
			),
		)
	);

	if ( ! class_exists( 'WPBakeryShortCode_Porto_Product_Category' ) ) {
		class WPBakeryShortCode_Porto_Product_Category extends WPBakeryShortCode {
		}
	}
}
