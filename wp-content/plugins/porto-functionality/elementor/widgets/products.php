<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Porto Elementor Products Widget
 *
 * Porto Elementor widget to display products.
 *
 * @since 5.1.0
 */

use Elementor\Controls_Manager;

class Porto_Elementor_Products_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'porto_products';
	}

	public function get_title() {
		return __( 'Porto Products', 'porto-functionality' );
	}

	public function get_categories() {
		return array( 'porto-elements' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_script_depends() {
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			return array( 'porto-elementor-widgets-js', 'isotope' );
		} else {
			return array();
		}
	}

	protected function _register_controls() {
		$order_by_values  = array_slice( porto_vc_woo_order_by(), 1 );
		$order_way_values = array_slice( porto_vc_woo_order_way(), 1 );
		$slider_options   = porto_update_vc_options_to_elementor( porto_vc_product_slider_fields() );

		$slider_options['nav_pos2']['condition']['navigation']       = 'yes';
		$slider_options['nav_type']['condition']['navigation']       = 'yes';
		$slider_options['autoplay_timeout']['condition']['autoplay'] = 'yes';

		$attributes = array( '' => '' );
		if ( class_exists( 'Woocommerce' ) ) {
			$attributes_tax = wc_get_attribute_taxonomies();
			foreach ( $attributes_tax as $attribute ) {
				$attributes[ $attribute->attribute_name ] = $attribute->attribute_label;
			}
		}

		$this->start_controls_section(
			'section_products',
			array(
				'label' => __( 'Products Selector', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'porto-functionality' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Title', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'status',
			array(
				'label'   => __( 'Product Status', 'porto-functionality' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''          => __( 'All', 'porto-functionality' ),
					'featured'  => __( 'Featured', 'porto-functionality' ),
					'on_sale'   => __( 'On Sale', 'porto-functionality' ),
					'pre_order' => __( 'Pre-Order', 'porto-functionality' ),
				),
			)
		);

		$this->add_control(
			'category',
			array(
				'type'        => 'porto_ajaxselect2',
				'label'       => __( 'Category IDs or slugs', 'porto-functionality' ),
				'description' => __( 'comma separated list of category ids or slugs', 'porto-functionality' ),
				'multiple'    => 'true',
				'options'     => 'product_cat',
				'label_block' => true,
			)
		);

		$this->add_control(
			'ids',
			array(
				'type'        => 'porto_ajaxselect2',
				'label'       => __( 'Product IDs', 'porto-functionality' ),
				'description' => __( 'comma separated list of product ids', 'porto-functionality' ),
				'multiple'    => 'true',
				'options'     => 'product',
				'label_block' => true,
			)
		);

		$this->add_control(
			'count',
			array(
				'type'  => Controls_Manager::SLIDER,
				'label' => __( 'Products Count', 'porto-functionality' ),
				'range' => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Order by', 'porto-functionality' ),
				'options'     => array_combine( array_values( $order_by_values ), array_keys( $order_by_values ) ),
				/* translators: %s: Wordpres codex page */
				'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'porto-functionality' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			)
		);

		$this->add_control(
			'order',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Order way', 'porto-functionality' ),
				'options'     => array_combine( array_values( $order_way_values ), array_keys( $order_way_values ) ),
				/* translators: %s: Wordpres codex page */
				'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'porto-functionality' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			)
		);

		$this->add_control(
			'attribute',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Attribute', 'porto-functionality' ),
				'options' => $attributes,
				'default' => '',
			)
		);
		foreach ( $attributes as $a_name => $a_label ) {
			if ( empty( $a_name ) ) {
				continue;
			}
			$terms = get_terms(
				array(
					'taxonomy'   => wc_attribute_taxonomy_name( $a_name ),
					'hide_empty' => false,
				)
			);
			$attrs = array();
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$attrs[ $term->slug ] = $term->name;
				}
			}
			$this->add_control(
				'filter_' . esc_html( $a_name ),
				array(
					'type'      => Controls_Manager::SELECT2,
					'label'     => esc_html( $a_label ),
					'options'   => $attrs,
					'multiple'  => true,
					'default'   => '',
					'condition' => array(
						'attribute' => esc_html( $a_name ),
					),
				)
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_products_layout',
			array(
				'label' => __( 'Products Layout', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'view',
			array(
				'label'   => __( 'View', 'porto-functionality' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array_combine( array_values( porto_sh_commons( 'products_view_mode' ) ), array_keys( porto_sh_commons( 'products_view_mode' ) ) ),
			)
		);

		$this->add_control(
			'grid_layout',
			array(
				'label'     => __( 'Grid Layout', 'porto-functionality' ),
				'type'      => 'image_choose',
				'default'   => '1',
				'options'   => array_combine( array_values( porto_sh_commons( 'masonry_layouts' ) ), array_keys( porto_sh_commons( 'masonry_layouts' ) ) ),
				'condition' => array(
					'view' => 'creative',
				),
			)
		);

		$this->add_control(
			'grid_height',
			array(
				'label'     => __( 'Grid Height', 'porto-functionality' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '600px',
				'condition' => array(
					'view' => 'creative',
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => __( 'Column Spacing (px)', 'porto-functionality' ),
				'description' => __( 'Leave blank if you use theme default value.', 'porto-functionality' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'condition'   => array(
					'view' => array( 'grid', 'creative', 'products-slider' ),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Columns', 'porto-functionality' ),
				'condition' => array(
					'view' => array( 'products-slider', 'grid', 'divider' ),
				),
				'default'   => '4',
				'options'   => porto_sh_commons( 'products_columns' ),
			)
		);

		$this->add_control(
			'columns_mobile',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Columns on mobile ( <= 575px )', 'porto-functionality' ),
				'condition' => array(
					'view' => array( 'products-slider', 'grid', 'divider', 'list' ),
				),
				'default'   => '',
				'options'   => array(
					''  => __( 'Default', 'porto-functionality' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
			)
		);

		$this->add_control(
			'column_width',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Column Width', 'porto-functionality' ),
				'condition' => array(
					'view' => array( 'products-slider', 'grid', 'divider' ),
				),
				'options'   => array_combine( array_values( porto_sh_commons( 'products_column_width' ) ), array_keys( porto_sh_commons( 'products_column_width' ) ) ),
			)
		);

		$this->add_control(
			'pagination_style',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Pagination Style', 'porto-functionality' ),
				'condition' => array(
					'view' => array( 'list', 'grid', 'divider' ),
				),
				'options'   => array(
					''          => __( 'No pagination', 'porto-functionality' ),
					'default'   => __( 'Default' ),
					'load_more' => __( 'Load more' ),
				),
			)
		);

		$this->add_control(
			'addlinks_pos',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Product Layout', 'porto-functionality' ),
				'description' => __( 'Select position of add to cart, add to wishlist, quickview.', 'porto-functionality' ),
				'options'     => array_combine( array_values( porto_sh_commons( 'products_addlinks_pos' ) ), array_keys( porto_sh_commons( 'products_addlinks_pos' ) ) ),
			)
		);

		$this->add_control(
			'show_sort',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => __( 'Show Sort by', 'porto-functionality' ),
				'options'     => array(
					'all'     => __( 'All', 'porto-functionality' ),
					'popular' => __( 'Popular', 'porto-functionality' ),
					'date'    => __( 'Date', 'porto-functionality' ),
					'rating'  => __( 'Rating', 'porto-functionality' ),
					'onsale'  => __( 'On Sale', 'porto-functionality' ),
				),
				'multiple'    => true,
				'label_block' => true,
			)
		);

		$this->add_control(
			'show_sales_title',
			array(
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Title for "Sort by Popular"', 'porto-functionality' ),
				'condition' => array(
					'show_sort' => 'popular',
				),
			)
		);

		$this->add_control(
			'show_new_title',
			array(
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Title for "Sort by Date"', 'porto-functionality' ),
				'condition' => array(
					'show_sort' => 'date',
				),
			)
		);

		$this->add_control(
			'show_rating_title',
			array(
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Title for "Sort by Rating"', 'porto-functionality' ),
				'condition' => array(
					'show_sort' => 'rating',
				),
			)
		);

		$this->add_control(
			'show_onsale_title',
			array(
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Title for "On Sale"', 'porto-functionality' ),
				'condition' => array(
					'show_sort' => 'onsale',
				),
			)
		);

		$this->add_control(
			'category_filter',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => __( 'Show category filter', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'filter_style',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Filter Style', 'porto-functionality' ),
				'options'     => array(
					''           => __( 'Vertical', 'porto-functionality' ),
					'horizontal' => __( 'Horizontal', 'porto-functionality' ),
				),
				'description' => __( 'This field is used only when using "sort by" or "category filter".', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'use_simple',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => __( 'Use simple layout?', 'porto-functionality' ),
				'description' => __( 'If you check this option, it will display product title and price only.', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'overlay_bg_opacity',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => __( 'Overlay Background Opacity (%)', 'porto-functionality' ),
				'range'     => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'condition' => array(
					'addlinks_pos' => array( 'onimage2', 'onimage3' ),
				),
				'default'   => array(
					'unit' => '%',
					'size' => 30,
				),
			)
		);

		$this->add_control(
			'image_size',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Image Size', 'porto-functionality' ),
				'options'   => array_combine( array_values( porto_sh_commons( 'image_sizes' ) ), array_keys( porto_sh_commons( 'image_sizes' ) ) ),
				'default'   => '',
				'condition' => array(
					'view' => array( 'products-slider', 'grid', 'divider', 'list' ),
				),
			)
		);

		$this->add_control(
			'el_class',
			array(
				'label' => __( 'Custom Class', 'porto-functionality' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			array(
				'label'     => __( 'Slider Options', 'porto-functionality' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'view' => 'products-slider',
				),
			)
		);

		foreach ( $slider_options as $key => $opt ) {
			unset( $opt['condition']['view'] );
			$this->add_control( $key, $opt );
		}

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		if ( $template = porto_shortcode_woo_template( 'porto_products' ) ) {
			if ( empty( $atts['spacing'] ) ) {
				$atts['spacing'] = '';
			}
			if ( ! empty( $atts['category'] ) && is_array( $atts['category'] ) ) {
				$atts['category'] = implode( ',', $atts['category'] );
			}
			if ( ! empty( $atts['ids'] ) && is_array( $atts['ids'] ) ) {
				$atts['ids'] = implode( ',', $atts['ids'] );
			}
			include $template;
		}
	}

	protected function content_template() {}
}
