<?php
class MailViewWpf extends ViewWpf {
	public function getTabContent() {
		FrameWpf::_()->getModule('templates')->loadJqueryUi();
		FrameWpf::_()->addScript('admin.' . $this->getCode(), $this->getModule()->getModPath() . 'js/admin.' . $this->getCode() . '.js');
		
		$this->assign('options', FrameWpf::_()->getModule('options')->getCatOpts( $this->getCode() ));
		$this->assign('testEmail', FrameWpf::_()->getModule('options')->get('notify_email'));
		return parent::getContent('mailAdmin');
	}
}
