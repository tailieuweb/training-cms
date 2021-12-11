<?php

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Icons_Manager;

/**
 * AnWP Post Grid Elements :: Classic Slider
 *
 * @since   0.6.0
 * @package AnWP_Post_Grid
 */

class AnWP_Post_Grid_Element_Classic_Slider extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 * @since  0.1.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'anwp-pg-classic-slider';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since  0.1.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Classic Slider', 'anwp-post-grid' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since  0.1.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'anwp-pg-element anwp-pg-classic-slider__admin-icon';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'carousel', 'posts', 'post', 'post carousel', 'posts carousel', 'posts slider', 'slider', 'anwp' ];
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'anwp-pg' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since  0.1.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		/**
		 * Before start of controls.
		 *
		 * @param AnWP_Post_Grid_Element_Classic_Slider $this The element.
		 *
		 * @since 0.8.3
		 */
		do_action( 'anwp-pg-el/element-classic-slider/before_controls_start', $this );

		/**
		 * Load Section - Query
		 *
		 * @param AnWP_Post_Grid_Element_Classic_Blog $this The element.
		 *
		 * @since 0.8.3
		 */
		do_action( 'anwp-pg-el/general/section_query', $this );

		/**
		 * Load Section - Header.
		 *
		 * @param AnWP_Post_Grid_Element_Classic_Blog $this The element.
		 *
		 * @since 0.7.0
		 */
		do_action( 'anwp-pg-el/general/section_header', $this );

		/**
		 * After Control Section - Header.
		 *
		 * @param AnWP_Post_Grid_Element_Classic_Slider $this The element.
		 *
		 * @since 0.7.0
		 */
		do_action( 'anwp-pg-el/element-classic-slider/after_control_section_header', $this );

		/*
		|--------------------------------------------------------------------
		| Post Icons
		|--------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_anwp_grid_post_icon_layout',
			[
				'label' => __( 'Post Icon', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_post_icon',
			[
				'label'        => __( 'Show Post Icon', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'post_icon_size',
			[
				'label'        => __( 'Icon Size', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'16' => __( '16 px', 'anwp-post-grid' ),
					'24' => __( '24 px', 'anwp-post-grid' ),
					'36' => __( '36 px', 'anwp-post-grid' ),
				],
				'default'      => '16',
				'prefix_class' => 'anwp-pg-post-teaser__post-icon--size-',
			]
		);

		$this->add_control(
			'post_icon_position',
			[
				'label'        => __( 'Icon Position', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					''             => __( 'top right', 'anwp-post-grid' ),
					'center'       => __( 'center', 'anwp-post-grid' ),
					'bottom-right' => __( 'bottom right', 'anwp-post-grid' ),
				],
				'default'      => '',
				'prefix_class' => 'anwp-pg-post-teaser__post-icon--position-',
			]
		);

		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------
		| Styles and Layout Section
		|--------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_anwp_grid_style_layout',
			[
				'label' => __( 'Styles and Layout', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => __( 'Show Excerpt', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hr_style_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'        => __( 'Show Category', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'category_limit',
			[
				'label'     => __( 'Category Limit', 'anwp-post-grid' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 7,
				'step'      => 1,
				'default'   => 1,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => __( 'Show Post Date', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'        => __( 'Show Comments & Views', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hr_style_4',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'           => __( 'Post Card Height (px)', 'anwp-post-grid' ),
				'type'            => Controls_Manager::SLIDER,
				'size_units'      => [ 'px' ],
				'range'           => [
					'px' => [
						'min'  => 150,
						'max'  => 500,
						'step' => 10,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'unit' => 'px',
					'size' => 180,
				],
			]
		);

		$this->add_control(
			'hr_style_7',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'label'   => __( 'Image Size', 'anwp-post-grid' ),
				'name'    => 'grid_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'medium',
			]
		);

		$this->add_control(
			'hr_style_8',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'category_background',
			[
				'label'     => __( 'Category Background Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-classic-slider .anwp-pg-category__wrapper-filled' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'category_text_color',
			[
				'label'     => __( 'Category Text Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-classic-slider .anwp-pg-category__wrapper-filled' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => __( 'Post Card Background Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => true,
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-classic-slider .anwp-pg-post-teaser__content' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'card_bg_color_hover',
			[
				'label'     => __( 'Post Card Background Color on Hover', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => true,
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-classic-slider .anwp-pg-post-teaser--layout-d:hover .anwp-pg-post-teaser__content' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'hr_style_21',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'post_content_text_align',
			[
				'label'     => __( 'Title and Meta Text Align', 'anwp-post-grid' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''       => __( 'default', 'anwp-post-grid' ),
					'center' => __( 'center', 'anwp-post-grid' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .anwp-pg-post-teaser__bottom-meta' => '-ms-flex-pack: {{VALUE}} !important; justify-content: {{VALUE}} !important;: ;',
				],
			]
		);

		$this->add_control(
			'post_title_options_heading',
			[
				'label'     => __( 'Post Title', 'anwp-post-grid' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_teaser_title',
				'label'    => __( 'Typography', 'anwp-post-grid' ),
				'selector' => '{{WRAPPER}} .anwp-pg-post-teaser__title a',
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label'     => __( 'Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_meta_options_heading',
			[
				'label'     => __( 'Post Meta', 'anwp-post-grid' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_teaser_meta',
				'label'    => __( 'Typography', 'anwp-post-grid' ),
				'selector' => '{{WRAPPER}} .anwp-pg-post-teaser__meta-comments, {{WRAPPER}} .anwp-pg-post-teaser__category-wrapper, {{WRAPPER}} .anwp-pg-post-teaser__meta-views, {{WRAPPER}} .anwp-pg-post-teaser__bottom-meta',
			]
		);

		$this->add_control(
			'post_meta_vertical_margin',
			[
				'label'     => __( 'Vertical Margin', 'anwp-post-grid' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'-5px' => '-5px',
					'0'    => '0',
					'5px'  => '5px',
					'10px' => '10px',
					'15px' => '15px',
					'20px' => '20px',
				],
				'default'   => '10px',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__bottom-meta' => 'margin-top: {{VALUE}}; margin-bottom: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_meta_background_color',
			[
				'label'     => __( 'Background Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__bottom-meta' => 'background-color: {{VALUE}}; padding: 3px 5px;',
				],
			]
		);

		$this->add_control(
			'post_meta_text_color',
			[
				'label'     => __( 'Text Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__bottom-meta' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .anwp-pg-post-teaser__bottom-meta .anwp-pg-icon' => 'fill: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'post_excerpt_options_heading',
			[
				'label'     => __( 'Post Excerpt', 'anwp-post-grid' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'excerpt_num_words',
			[
				'label'       => __( 'Number of Words', 'anwp-post-grid' ),
				'label_block' => false,
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'default'     => 30,
			]
		);

		$this->add_control(
			'excerpt_source',
			[
				'label'       => __( 'Excerpt Source', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'description' => __( 'Use "Post Content" when you want to increase number of words or allow HTML', 'anwp-post-grid' ),
				'options'     => [
					''             => __( 'Default (excerpt)', 'anwp-post-grid' ),
					'post_content' => __( 'Post Content', 'anwp-post-grid' ),
				],
				'default'     => '',
			]
		);

		$this->add_control(
			'excerpt_html',
			[
				'label'        => __( 'Allow HTML', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'post_excerpt_text_color',
			[
				'label'     => __( 'Text Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__excerpt' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'post_excerpt_text_align',
			[
				'label'     => __( 'Text Align', 'anwp-post-grid' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''       => __( 'default', 'anwp-post-grid' ),
					'center' => __( 'center', 'anwp-post-grid' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .anwp-pg-post-teaser__excerpt' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------
		| Read More button
		|--------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_anwp_grid_read_more',
			[
				'label' => __( 'Read More', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'        => __( 'Show "Read More" button', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'read_more_label',
			[
				'label'       => __( '"Read more" alternative text', 'anwp-post-grid' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'read_more_class',
			[
				'label'       => __( '"Read more" custom classes', 'anwp-post-grid' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'read_more_class_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => 'You can use Bootstrap Button classes. <br>E.g.: "btn btn-danger"<br> More info <a target="_blank" href="https://getbootstrap.com/docs/4.5/components/buttons/">here</a><br>Default: "btn btn-sm btn-outline-info w-100 text-decoration-none"',
			]
		);

		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------
		| Slider Options
		|--------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_anwp_grid_slider',
			[
				'label' => __( 'Slider Options', 'anwp-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'       => __( 'Slides to Show', 'anwp-post-grid' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 8,
				'default'     => 3,
				'required'    => true,
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'required' => false,
						'default'  => 2,
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'required' => false,
						'default'  => 1,
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label'       => __( 'Slides to Scroll', 'anwp-post-grid' ),
				'description' => __( 'Set how many slides are scrolled per swipe.', 'anwp-post-grid' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 8,
				'default'     => 1,
				'required'    => true,
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'required' => false,
						'default'  => 1,
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'required' => false,
						'default'  => 1,
					],
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'anwp-post-grid' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'anwp-post-grid' ),
					'no'  => __( 'No', 'anwp-post-grid' ),
				],
			]
		);

		$this->add_control(
			'autoplay_delay',
			[
				'label'     => __( 'Autoplay Speed (ms)', 'anwp-post-grid' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'spacing_between',
			[
				'label'   => __( 'Distance between slides in px', 'anwp-post-grid' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => __( 'Direction', 'anwp-post-grid' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ltr',
				'options' => [
					'ltr' => __( 'Left', 'anwp-post-grid' ),
					'rtl' => __( 'Right', 'anwp-post-grid' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label'       => __( 'Effect', 'anwp-post-grid' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'slide',
				'options'     => [
					'slide' => __( 'Slide', 'anwp-post-grid' ),
					'fade'  => __( 'Fade', 'anwp-post-grid' ),
				],
				'description' => __( 'Fade effect works when "Slides to Show" is 1', 'anwp-post-grid' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'anwp-post-grid' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dots',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'anwp-post-grid' ),
					'arrows' => __( 'Arrows', 'anwp-post-grid' ),
					'dots'   => __( 'Dots', 'anwp-post-grid' ),
					'none'   => __( 'None', 'anwp-post-grid' ),
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'        => __( 'Arrows Position', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inside',
				'options'      => [
					'inside'  => __( 'Inside', 'anwp-post-grid' ),
					'outside' => __( 'Outside', 'anwp-post-grid' ),
				],
				'prefix_class' => 'elementor-arrows-position-',
				'condition'    => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'        => __( 'Dots Position', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'outside',
				'options'      => [
					'outside' => __( 'Outside', 'anwp-post-grid' ),
					'inside'  => __( 'Inside', 'anwp-post-grid' ),
				],
				'prefix_class' => 'elementor-pagination-position-',
				'condition'    => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'anwp-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label'     => __( 'Dots Size', 'anwp-post-grid' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'enable_observer',
			[
				'label'        => __( 'Enable Mutation Observer', 'anwp-post-grid' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Use it to fix slider rendering in hidden areas on initialization (e.g.: tabs)', 'anwp-post-grid' ),
				'label_on'     => __( 'Yes', 'anwp-post-grid' ),
				'label_off'    => __( 'No', 'anwp-post-grid' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/**
		 * Before end of controls.
		 *
		 * @param AnWP_Post_Grid_Element_Classic_Slider $this The element.
		 *
		 * @since 0.7.0
		 */
		do_action( 'anwp-pg-el/element-classic-slider/before_controls_end', $this );

		/**
		 * Before end of controls.
		 *
		 * @param Widget_Base $this The element.
		 *
		 * @since 0.7.0
		 */
		do_action( 'anwp-pg-el/element/before_controls_end', $this );
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since  0.6.0
	 * @access protected
	 */
	protected function render() {

		/*
		|--------------------------------------------------------------------
		| Merge arguments into defaults array
		|--------------------------------------------------------------------
		*/
		$data = (object) wp_parse_args(
			$this->get_settings_for_display(),
			[
				'posts_to_show' => 'latest',
				'limit'         => 3,
				'header_icon'   => '',
			]
		);

		/*
		|--------------------------------------------------------------------
		| Get Posts
		|--------------------------------------------------------------------
		*/
		$data->slider_posts = anwp_post_grid()->elements->get_grid_posts( $data );

		// Icon
		if ( ! empty( $data->header_icon ) ) {
			ob_start();

			Icons_Manager::render_icon( $data->header_icon, [ 'class' => 'anwp-pg-widget-header__icon' ], 'span' );
			$data->header_icon = ob_get_clean();
		}

		// Card Height
		$data->post_card_height_classes = anwp_post_grid()->elements->get_post_card_height( $data );

		/*
		|--------------------------------------------------------------------
		| Render
		|--------------------------------------------------------------------
		*/
		anwp_post_grid()->load_partial( $data, 'classic-slider' );
	}
}

