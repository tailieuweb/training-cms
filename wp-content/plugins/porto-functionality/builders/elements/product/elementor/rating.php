<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Porto Elementor Custom Product Rating Widget
 *
 * Porto Elementor widget to display review ratings on the single product page when using custom product layout
 *
 * @since 5.4.0
 */

use Elementor\Controls_Manager;

class Porto_Elementor_CP_Rating_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'porto_cp_rating';
	}

	public function get_title() {
		return __( 'Product Rating', 'porto-functionality' );
	}

	public function get_categories() {
		return array( 'custom-product' );
	}

	public function get_keywords() {
		return array( 'product', 'rating', 'review', 'stars', 'feedback' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_cp_rating',
			array(
				'label' => __( 'Product Rating', 'porto-functionality' ),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rating_font',
				'scheme'   => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'label'    => __( 'Typograhy', 'porto-functionality' ),
				'selector' => '{{WRAPPER}} .star-rating',
			)
		);

		$this->add_control(
			'rating_bgcolor',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Star Color', 'porto-functionality' ),
				'selectors' => array(
					'{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rating_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Active Color', 'porto-functionality' ),
				'selectors' => array(
					'{{WRAPPER}} .star-rating span:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( class_exists( 'PortoCustomProduct' ) ) {
			echo PortoCustomProduct::get_instance()->shortcode_single_product_rating( $settings );
		}
	}
}
