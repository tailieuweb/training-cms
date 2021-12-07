<?php
class TableUsage_StatWpf extends TableWpf {
	public function __construct() {
		$this->_table = '@__usage_stat';
		$this->_id = 'id';     
		$this->_alias = 'sup_usage_stat';
		$this->_addField('id', 'hidden', 'int', 0, esc_html__('id', 'woo-product-filter'))
			->_addField('code', 'hidden', 'text', 0, esc_html__('code', 'woo-product-filter'))
			->_addField('visits', 'hidden', 'int', 0, esc_html__('visits', 'woo-product-filter'))
			->_addField('spent_time', 'hidden', 'int', 0, esc_html__('spent_time', 'woo-product-filter'))
			->_addField('modify_timestamp', 'hidden', 'int', 0, esc_html__('modify_timestamp', 'woo-product-filter'));
	}
}
