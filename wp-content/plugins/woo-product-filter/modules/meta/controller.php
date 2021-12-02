<?php
class MetaControllerWpf extends ControllerWpf {

	protected $_code = 'meta';

	public function doMetaIndexing() {
		check_ajax_referer('wpf-save-nonce', 'wpfNonce');
		if (!current_user_can('manage_options')) {
			wp_die();
		}
		
		$res = new ResponseWpf();
		$result = $this->getModel()->recalcMetaValues();
		if ( false != $result ) {
			$res->addMessage(esc_html__('Done', 'woo-product-filter'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
}
