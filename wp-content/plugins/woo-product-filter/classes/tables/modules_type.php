<?php
class TableModules_TypeWpf extends TableWpf {
	public function __construct() {
		$this->_table = '@__modules_type';
		$this->_id = 'id';     /*Let's associate it with posts*/
		$this->_alias = 'sup_m_t';
		$this->_addField($this->_id, 'text', 'int', '', esc_html__('ID', 'woo-product-filter'))->
				_addField('label', 'text', 'varchar', '', esc_html__('Label', 'woo-product-filter'), 128);
	}
}
