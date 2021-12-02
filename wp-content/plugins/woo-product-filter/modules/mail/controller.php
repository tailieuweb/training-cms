<?php
class MailControllerWpf extends ControllerWpf {
	public function testEmail() {
		$res = new ResponseWpf();
		$email = ReqWpf::getVar('test_email', 'post');
		if ($this->getModel()->testEmail($email)) {
			$res->addMessage(esc_html__('Now check your email inbox / spam folders for test mail.', 'woo-product-filter'));
		} else {
			$res->pushError ($this->getModel()->getErrors());
		}
		$res->ajaxExec();
	}
	public function saveMailTestRes() {
		$res = new ResponseWpf();
		$result = (int) ReqWpf::getVar('result', 'post');
		FrameWpf::_()->getModule('options')->getModel()->save('mail_function_work', $result);
		$res->ajaxExec();
	}
	public function saveOptions() {
		$res = new ResponseWpf();
		$optsModel = FrameWpf::_()->getModule('options')->getModel();
		$submitData = ReqWpf::get('post');
		if ($optsModel->saveGroup($submitData)) {
			$res->addMessage(esc_html__('Done', 'woo-product-filter'));
		} else {
			$res->pushError($optsModel->getErrors());
		}
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			WPF_USERLEVELS => array(
				WPF_ADMIN => array('testEmail', 'saveMailTestRes', 'saveOptions')
			),
		);
	}
}
