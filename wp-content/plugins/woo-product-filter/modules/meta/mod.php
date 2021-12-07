<?php

class MetaWpf extends ModuleWpf {
	private $calculated = false;

	public function init() {
		parent::init();
		DispatcherWpf::addFilter( 'optionsDefine', array( $this, 'addOptions' ) );
		add_action( 'woocommerce_update_product', array( $this, 'recalcProductMetaValues' ), 100, 1 );
		add_action( 'woocommerce_product_set_stock_status', array( $this, 'recalcProductStockStatus' ), 100, 1 );
		add_action( 'woocommerce_variation_set_stock_status', array( $this, 'recalcProductStockStatus' ), 100, 1 );
		add_action( 'wpf_calc_meta_indexing', array( $this->getModel(), 'recalcMetaValues' ), 10, 1 );
		add_action( 'wpf_calc_meta_indexing_shedule', array( $this, 'recalcMetaIndexingShedule' ), 10, 1 );

		add_filter('woocommerce_product_csv_importer_steps', array($this, 'recalcAfterImporting'));
	}
	public function isGlobalCalcRunning() {
		return FrameWpf::_()->getModule('options')->getModel()->get('start_indexing') == 2;
	}
	public function isDisabledAutoindexing() {
		$param = FrameWpf::_()->getModule('options')->getModel()->get('disable_autoindexing');
		return false === $param ? 0 : ( (int) $param );
	}

	public function recalcAfterImporting( $steps ) {
		$step = ReqWpf::getVar('step');
		if (!is_null($step) && 'done' == $step && !$this->isDisabledAutoindexing()) {
			wp_schedule_single_event( time() + 1, 'wpf_calc_meta_indexing' );
		}
		return $steps;
	}

	public function addOptions( $options ) {
		$opts = array_merge(array(
			'start_indexing' => array(
				'label' => esc_html__('Start indexing product parameters', 'woo-product-filter'),
				'desc' => esc_html__('For correct and fast operation of filters, the plugin creates index tables for product parameters. This tables are automatically rebuilt by editing / creating products. But if you edited products with third-party plugins or methods, and/or noticed that the filter does not work correctly, then click this button to forcefully rebuild the index tables. If you have a lot of products, the process may take a while.', 'woo-product-filter'),
				'html' => 'startMetaButton',
				'def' => '',
			),
			'disable_autoindexing' => array(
				'label' => esc_html__( 'Disable automatic calculation of index tables after editing products.', 'woo-product-filter' ),
				'desc'  => esc_html__( 'This can be useful if you add products only through imports. Then after importing, just do a full recalculation of the index tables once by clicking the button above.', 'woo-product-filter' ),
				'html'  => 'checkboxHiddenVal',
				'def'   => '0',
			),
			'indexing_schedule'    => array(
				'label'        => esc_html__( 'Start indexing on a schedule', 'woo-product-filter' ),
				'desc'         => esc_html__( 'Indexing will start at the selected time according to the schedule', 'woo-product-filter' ),
				'html'         => 'checkboxHiddenVal',
				'def'          => '0',
				'add_sub_opts' => array( $this, 'getSettingsIndexingSchedule' ),
			),
			'logging' => array(
				'label' => esc_html__('Logging', 'woo-product-filter'),
				'desc' => esc_html__('Save debug messages to the WooCommerce SystemStatus Log', 'woo-product-filter'),
				'html' => 'checkboxHiddenVal',
				'def' => '0',
			),
		), $options['general']['opts']);

		$options['general']['opts'] = $opts;
		return $options;
	}

	public function getSettingsIndexingSchedule( $options ) {
		$hourSelect = FrameWpf::_()->getModule( 'options' )->getModel()->get( 'shedule_hour' );
		$hours      = array(
			'00',
			'01',
			'02',
			'03',
			'04',
			'05',
			'06',
			'07',
			'08',
			'09',
			'10',
			'11',
			'12',
			'13',
			'14',
			'15',
			'16',
			'17',
			'18',
			'19',
			'20',
			'21',
			'22',
			'23',
		);
		$hoursHtml  = '';
		foreach ( $hours as $value => $name ) {
			$selected  = ( (int) $hourSelect === $value ) ? 'selected' : '';
			$hoursHtml .= "<option value=\"{$value}\" {$selected}>{$name}</option>";
		}

		$daySelect = FrameWpf::_()->getModule( 'options' )->getModel()->get( 'shedule_day' );
		$days      = array(
			__( 'Everyday', 'woo-product-filter' ),
			__( 'Monday', 'woo-product-filter' ),
			__( 'Tuesday', 'woo-product-filter' ),
			__( 'Wednesday', 'woo-product-filter' ),
			__( 'Thursday', 'woo-product-filter' ),
			__( 'Friday', 'woo-product-filter' ),
			__( 'Saturday', 'woo-product-filter' ),
			__( 'Sunday', 'woo-product-filter' ),
		);
		$daysHtml  = '';
		foreach ( $days as $value => $name ) {
			$selected = ( (int) $daySelect === $value ) ? 'selected' : '';
			$daysHtml .= "<option value=\"{$value}\" {$selected}>{$name}</option>";
		}

		return "<div><select name=\"opt_values[shedule_hour]\">{$hoursHtml}</select> <select name=\"opt_values[shedule_day]\">{$daysHtml}</select></div>";
	}

	public function recalcProductMetaValues( $productId ) {
		if ( ! $this->isDisabledAutoindexing() ) {
			$this->getModel()->recalcMetaValues( $productId );
		}
	}

	public function recalcProductStockStatus( $productId ) {
		$this->getModel()->recalcMetaValues( $productId, array( 'meta_key' => '_stock_status' ) );
	}

	public function calcNeededMetaValues( $one = false ) {
		if ( ! $this->isGlobalCalcRunning() ) {
			if ( ! $one || ! $this->calculated ) {
				$this->getModel()->recalcMetaValues( 0, array( 'status' => array( 0, 2 ) ) );
			}
			$this->calculated = true;
		}
	}


	public function recalcMetaIndexingShedule() {
		$daySelect = FrameWpf::_()->getModule( 'options' )->getModel()->get( 'shedule_day' );

		if ( '0' !== $daySelect && gmdate( 'N' ) !== $daySelect ) {
			return false;
		}

		$hourSelect       = FrameWpf::_()->getModule( 'options' )->getModel()->get( 'shedule_hour' );
		$timestampShedule = mktime( $hourSelect, 0, 0 );
		if ( time() < $timestampShedule ) {
			return false;
		}

		$timestampLastIndexing = FrameWpf::_()->getModule( 'options' )->getModel()->getChanged( 'start_indexing' );
		if ( $timestampLastIndexing > $timestampShedule ) {
			return false;
		}

		$this->getModel()->recalcMetaValues();

	}


}
