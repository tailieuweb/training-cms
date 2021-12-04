<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Woofilters_ElementorWidgetWpf extends Widget_Base {
	
	public static $adPath = '';
	public static $labelPro = '';
	
	public function __construct ( $data = array(), $args = null ) {
		parent::__construct($data, $args);
		
		$isWooCommercePluginActivated = FrameWpf::_()->getModule('woofilters')->isWooCommercePluginActivated();
		if (!$isWooCommercePluginActivated) {
			return;
		}
		
		$isPro = FrameWpf::_()->isPro();
		$modPath = FrameWpf::_()->getModule('woofilters')->getModPath();
		if (is_admin()) {
			FrameWpf::_()->getModule('templates')->loadCoreJs();
			FrameWpf::_()->getModule('templates')->loadAdminCoreJs();
			wp_enqueue_style( 'wp-color-picker' );

			FrameWpf::_()->getModule('templates')->loadCoreCss();
			FrameWpf::_()->getModule('templates')->loadChosenSelects();
			FrameWpf::_()->addScript('notify-js', WPF_JS_PATH . 'notify.js', array(), false, true);
			FrameWpf::_()->addScript('chosen.order.jquery.min.js', $modPath . 'js/chosen.order.jquery.min.js');
			FrameWpf::_()->addJSVar('wp-color-picker', 'wpColorPickerL10n', array());
			FrameWpf::_()->addScript('admin.filters', $modPath . 'js/admin.woofilters.js', array('wp-color-picker'));
			FrameWpf::_()->addScript('admin.wp.colorpicker.alhpa.js', WPF_JS_PATH . 'admin.wp.colorpicker.alpha.js', array('wp-color-picker'));
			FrameWpf::_()->addScript('adminOptionsWpf', WPF_JS_PATH . 'admin.options.js', array(), false, true);

			FrameWpf::_()->addStyle('admin.filters', $modPath . 'css/admin.woofilters.css');
			
			FrameWpf::_()->getModule('woofilters')->getView()->addCommonAssets($modPath);
			FrameWpf::_()->getModule('woofilters')->getView()->addPluginCustomStyles($modPath, true);
			
			FrameWpf::_()->addScript('jquery.slider.js.jshashtable', $modPath . 'js/jquery_slider/jshashtable-2.1_src.js');
			FrameWpf::_()->addScript('jquery.slider.js.numberformatter', $modPath . 'js/jquery_slider/jquery.numberformatter-1.2.3.js');
			FrameWpf::_()->addScript('jquery.slider.js.dependClass', $modPath . 'js/jquery_slider/jquery.dependClass-0.1.js');
			FrameWpf::_()->addScript('jquery.slider.js.draggable', $modPath . 'js/jquery_slider/draggable-0.1.js');
			FrameWpf::_()->addScript('jquery.slider.js', $modPath . 'js/jquery_slider/jquery.slider.js');
			FrameWpf::_()->addStyle('jquery.slider.css', $modPath . 'css/jquery.slider.min.css');
			
			if ( $isPro ) {
				FrameWpf::_()->getModule('woofilterpro')->addScriptsContent(true, array());
			}
			
			FrameWpf::_()->addStyle('admin.woofilters.elementor', FrameWpf::_()->getModule('woofilters_widget')->getModPath() . 'css/admin.woofilters.elementor.css');
			FrameWpf::_()->addScript('admin.woofilters.elementor', FrameWpf::_()->getModule('woofilters_widget')->getModPath() . 'js/admin.woofilters.elementor.js', array('admin.filters'), false, true);
			
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				FrameWpf::_()->addJSVar('admin.filters', 'isElementorEditMode', '1');
			}
			FrameWpf::_()->addJSVar('admin.filters', 'url', admin_url('admin-ajax.php'));
			list( $filtersOpts, $filtersSettings ) = $this->getFiltersSettings();
			FrameWpf::_()->addJSVar('admin.filters', 'filtersSettings', $filtersSettings);
			FrameWpf::_()->addJSVar('admin.filters', 'wpfNonce', wp_create_nonce('wpf-save-nonce'));
		}
		
		if (!$isPro) {
			static::$adPath = FrameWpf::_()->getModule('woofilters')->getModPath() . 'img/ad/';
			static::$labelPro = ' Pro';
		}
	}
	
	protected function getFiltersSettings() {
		$filters = FrameWpf::_()->getModule('woofilters')->getModel()->getFromTbl();
		$filtersOpts = array();
		$filtersOpts[0] = 'Select';
		$filtersOpts['new'] = 'Create New';
		$filtersSettings = array();
		foreach ($filters as $filter) {
			$filtersOpts[ $filter['id'] ] = $filter['title'];
			$filtersSettings[ $filter['id'] ] = unserialize($filter['setting_data']);
		}
		
		return array( $filtersOpts, $filtersSettings );
	}
	
	public function get_name() {
		return 'woofilters';
	}
	
	public function get_title() {
		return __( 'Woofilters', 'woo-product-filter' );
	}
	
	public function get_icon() {
		return 'eicon-table-of-contents';
	}
	
	public function get_keywords() {
		return array( 'woofilters', 'filter', 'woocommerce' );
	}
	
	public function get_categories() {
		return array( 'general', 'woocommerce-elements' );
	}
	
	public function get_script_depends() {
		return array();
	}
	
	public function is_reload_preview_required() {
		return true;
	}
	
	protected function _register_controls() {
		if (!is_admin()) {
			return false;
		}
		list( $filtersOpts ) = $this->getFiltersSettings();
		
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Select Woofilter', 'woo-product-filter' ),
			)
		);
		
		$this->add_control(
			'filter_id',
			array(
				'label' => __( 'Select Filter', 'woo-product-filter' ),
				'type' => Controls_Manager::SELECT,
				'options' => $filtersOpts,
				'default' => 0,
			)
		);
		
		$this->add_control(
			'filter_name',
			array(
				'label' => __( 'Filter Name', 'woo-product-filter' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter product filter name', 'woo-product-filter' ),
				'default' => '',
				'label_block' => true,
				'condition' => array(
					'filter_id' => 'new',
				),
			)
		);
		
		$this->add_control(
			'filter_create',
			array(
				'label' => __( 'Create Filter', 'woo-product-filter' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'none',
				'text' => __( 'Create', 'woo-product-filter' ),
				'button_type' => 'success',
				'event' => 'createFilter',
				'condition' => array(
					'filter_id' => 'new',
				),
			)
		);

		$this->end_controls_section();
		
		$this->addWooFilterContentTabControls();
		
		$this->addWooFilterStyleTabControls();
		
		$this->addWooFilterAndvancedTabControls();
	}
	
	protected function render() {
		$shortcode = $this->get_settings_for_display( 'filter_id' );
		?>
		<div class="elementor-woofilters"><?php echo $shortcode ? do_shortcode( '[wpf-filters id="' . $shortcode . '"]' ) : ''; ?></div>
		<?php
	}
	
	public function render_plain_content() {
		$shortcode = $this->get_settings_for_display( 'filter_id' );
		echo $shortcode ? do_shortcode( '[wpf-filters id="' . $shortcode . '"]' ) : '';
	}
	
	protected function _content_template() {}
	
	public function addWooFilterContentTabControls() {
		$this->start_controls_section(
			'section_filters',
			array(
				'label' => 'Filters',
				'tab' => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'filter_trigger',
			array(
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => false,
			)
		);
		
		$this->add_control(
			'filters_raw',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => FrameWpf::_()->getModule('woofilters')->getView()->getContent('woofiltersEditTabElementorFilters'),
			)
		);
		
		$this->add_control(
			'filter_save',
			array(
				'type' => Controls_Manager::BUTTON,
				'separator' => 'none',
				'text' => __( 'Save', 'woo-product-filter' ),
				'button_type' => 'success',
				'event' => 'saveFilter',
				'label_block' => false,
				'condition' => array(
					'filter_id!' => 'new',
				),
			)
		);
		
		$this->end_controls_section();
	}
	
	public function addWooFilterStyleTabControls() {
		
		$this->start_controls_section(
			'section_options',
			array(
				'label' => 'Options',
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'filter_options_trigger',
			array(
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => false,
			)
		);
		
		$this->add_control(
			'filters_raw_options',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => FrameWpf::_()->getModule('woofilters')->getView()->getContent('woofiltersEditTabElementorOptions'),
			)
		);
		
		$this->add_control(
			'filter_save_options',
			array(
				'type' => Controls_Manager::BUTTON,
				'separator' => 'none',
				'text' => __( 'Save', 'woo-product-filter' ),
				'button_type' => 'success',
				'event' => 'saveFilter',
				'label_block' => false,
				'condition' => array(
					'filter_id!' => 'new',
				),
			)
		);
		
		$this->end_controls_section();
	}
	
	public function addWooFilterAndvancedTabControls() {
		$this->start_controls_section(
			'section_design',
			array(
				'label' => __( 'Design', 'woo-product-filter' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			)
		);
		
		$this->add_control(
			'filter_design_trigger',
			array(
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => false,
			)
		);
		
		$this->add_control(
			'filters_raw_design',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => FrameWpf::_()->getModule('woofilters')->getView()->getContent('woofiltersEditTabElementorDesign'),
			)
		);
		
		$this->add_control(
			'filter_save_design',
			array(
				'type' => Controls_Manager::BUTTON,
				'separator' => 'none',
				'text' => __( 'Save', 'woo-product-filter' ),
				'button_type' => 'success',
				'event' => 'saveFilter',
				'label_block' => false,
				'condition' => array(
					'filter_id!' => 'new',
				),
			)
		);
		
		$this->end_controls_section();
	}
}
