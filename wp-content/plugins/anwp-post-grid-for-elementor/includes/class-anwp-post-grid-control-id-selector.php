<?php

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * AnWP Post Grid - ID Selector control.
 *
 * @since 0.8.3
 */
class AnWP_Post_Grid_Control_Id_Selector extends Base_Data_Control {

	/**
	 * Get control type.
	 *
	 * @since 0.8.3
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'anwp-id-selector';
	}

	/**
	 * Get control default settings.
	 *
	 * @since 0.8.3
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'context' => 'posts',
		];
	}

	public function enqueue() {

		// Styles
		if ( is_rtl() ) {
			wp_register_style( 'anwp-id-selector', AnWP_Post_Grid::url( 'admin/css/controls-styles-rtl.css' ), [], AnWP_Post_Grid::VERSION );
		} else {
			wp_register_style( 'anwp-id-selector', AnWP_Post_Grid::url( 'admin/css/controls-styles.css' ), [], AnWP_Post_Grid::VERSION );
		}

		wp_enqueue_style( 'anwp-id-selector' );

		// Scripts
		wp_register_script( 'modaal', AnWP_Post_Grid::url( 'vendor/modaal/modaal.min.js' ), [ 'jquery', 'underscore' ], '0.4.0', false );
		wp_register_script( 'anwp-id-selector', AnWP_Post_Grid::url( 'admin/js/controls-scripts.js' ), [ 'modaal' ], AnWP_Post_Grid::VERSION, false );
		wp_enqueue_script( 'anwp-id-selector' );

		wp_localize_script(
			'anwp-id-selector',
			'anwp_PG_ID_Selector',
			[
				'ajaxNonce'    => wp_create_nonce( 'ajax_anwp_pg_nonce' ),
				'selectorHtml' => $this->include_selector_modaal(),
			]
		);
	}

	/**
	 * Render control output in the editor.
	 *
	 * @since 0.8.3
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{data.label }}}</label>
			<div class="elementor-control-input-wrapper elementor-control-dynamic-switcher-wrapper">
				<input id="<?php echo esc_attr( $control_uid ); ?>" type="text" data-setting="{{ data.name }}"/>

				<button type="button" class="anwp-pg-selector anwp-pg-selector--visible anwp-ml-2" style="display: none;" data-context="{{ data.context }}">
					<span class="dashicons dashicons-search"></span>
				</button>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description anwp-pg-selector-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Get data control value.
	 *
	 * Retrieve the value of the data control from a specific Controls_Stack settings.

	 * @access public
	 *
	 * @param array $control  Control
	 * @param array $settings Element settings
	 *
	 * @return mixed Control values.
	 */
	public function get_value( $control, $settings ) {
		if ( ! isset( $control['default'] ) ) {
			$control['default'] = $this->get_default_value();
		}

		if ( isset( $settings[ $control['name'] ] ) ) {
			if ( is_array( $settings[ $control['name'] ] ) ) {
				$value = implode( ',', $settings[ $control['name'] ] );
			} else {
				$value = $settings[ $control['name'] ];
			}
		} else {
			$value = $control['default'];
		}

		return $value;
	}

	/**
	 * Load selector modal
	 *
	 * @return string
	 * @since 0.8.3
	 */
	public function include_selector_modaal() {
		ob_start();
		?>
		<div id="anwp-pg-selector-modaal">
			<div class="anwp-pg-shortcode-modal__header">
				<h3 style="margin: 0"><?php echo esc_html__( 'AnWP Post Grid Selector', 'anwp-post-grid' ); ?>: <span id="anwp-pg-selector-modaal__header-context"></span></h3>
			</div>
			<div class="anwp-pg-shortcode-modal__content" id="anwp-pg-selector-modaal__search-bar">
				<div class="anwp-pg-selector-modaal__bar-group anwp-mr-2 anwp-mt-2">
					<label for="anwp-pg-selector-modaal__search"><?php echo esc_html__( 'start typing ...', 'anwp-post-grid' ); ?></label>
					<input name="s" type="text" id="anwp-pg-selector-modaal__search" value="" class="fl-shortcode-attr code">
				</div>
			</div>
			<div class="anwp-pg-shortcode-modal__footer">
				<h4 style="margin: 0"><?php echo esc_html__( 'Selected Values', 'anwp-post-grid' ); ?>:
					<img id="anwp-pg-selector-modaal__initial-spinner" src="<?php echo esc_url( admin_url( 'images/spinner.gif' ) ); ?>" alt="spinner"/>
				</h4>
				<div id="anwp-pg-selector-modaal__selected"></div>
				<div id="anwp-pg-selector-modaal__selected-none">- <?php echo esc_html__( 'none', 'anwp-post-grid' ); ?> -</div>
			</div>
			<div class="anwp-pg-shortcode-modal__content" id="anwp-pg-selector-modaal__content"></div>
			<img id="anwp-pg-selector-modaal__search-spinner" src="<?php echo esc_url( admin_url( 'images/spinner.gif' ) ); ?>"/>
			<div class="anwp-pg-shortcode-modal__footer" id="anwp-pg-selector-modaal__footer">
				<button id="anwp-pg-selector-modaal__cancel" class="anwp-g-button"><?php echo esc_html__( 'Cancel', 'anwp-post-grid' ); ?></button>
				<button id="anwp-pg-selector-modaal__insert" class="anwp-g-button anwp-g-button-primary"><?php echo esc_html__( 'Insert', 'anwp-post-grid' ); ?></button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
