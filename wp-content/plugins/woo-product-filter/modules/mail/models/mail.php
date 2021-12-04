<?php
class MailModelWpf extends ModelWpf {
	public function testEmail( $email ) {
		$email = trim($email);
		if (!empty($email)) {
			/* translators: %s: url */
			if ($this->getModule()->send($email, esc_html__('Test email functionality', 'woo-product-filter'), sprintf(esc_html__('This is a test email for testing email functionality on your site, %s.', 'woo-product-filter'), WPF_SITE_URL))) {
				return true;
			} else {
				$this->pushError( $this->getModule()->getMailErrors() );
			}
		} else {
			$this->pushError(esc_html__('Empty email address', 'woo-product-filter'), 'test_email');
		}
		return false;
	}
}
