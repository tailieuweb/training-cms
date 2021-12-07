<?php
class MailWpf extends ModuleWpf {
	private $_smtpMailer = null;
	private $_sendMailMailer = null;
	
	public function init() {
		parent::init();
	}
	public function send( $to, $subject, $message, $fromName = '', $fromEmail = '', $replyToName = '', $replyToEmail = '', $additionalHeaders = array(), $additionalParameters = array() ) {
		$type = FrameWpf::_()->getModule('options')->get('mail_send_engine');
		$res = false;
		switch ($type) {
			case 'smtp':
				$res = $this->sendSmtpMail( $to, $subject, $message, $fromName, $fromEmail, $replyToName, $replyToEmail, $additionalHeaders, $additionalParameters );
				break;
			case 'sendmail':
				$res = $this->sendSendMailMail( $to, $subject, $message, $fromName, $fromEmail, $replyToName, $replyToEmail, $additionalHeaders, $additionalParameters );
				break;
			default:
				$res = $this->sendWpMail( $to, $subject, $message, $fromName, $fromEmail, $replyToName, $replyToEmail, $additionalHeaders, $additionalParameters );
				if (!$res) {
					// Sometimes it return false, but email was sent, and in such cases 
					// - in errors array there are only one - empty string - value.
					// Let's count this for now as Success sending
					$mailErrors = array_filter( $this->getMailErrors() );
					if (empty($mailErrors)) {
						$res = true;
					}
				}
				break;
		}
		return $res;
	}
	private function _getSmtpMailer() {
		if (!$this->_smtpMailer) {
			$this->_connectPhpMailer();
			$this->_smtpMailer = new PHPMailer();  // create a new object
			$this->_smtpMailer->IsSMTP(); // enable SMTP
			$this->_smtpMailer->Debugoutput = array($this, 'pushPhpMailerError');
			$this->_smtpMailer->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
			$this->_smtpMailer->SMTPAuth = true;  // authentication enabled
			$smtpSecure = FrameWpf::_()->getModule('options')->get('smtp_secure');
			if (!empty($smtpSecure)) {
				$this->_smtpMailer->SMTPSecure = $smtpSecure; // secure transfer enabled REQUIRED for GMail
			}
			$this->_smtpMailer->Host = trim(FrameWpf::_()->getModule('options')->get('smtp_host'));
			$this->_smtpMailer->Port = trim(FrameWpf::_()->getModule('options')->get('smtp_port')); 
			$this->_smtpMailer->Username = trim(FrameWpf::_()->getModule('options')->get('smtp_login'));  
			$this->_smtpMailer->Password = trim(FrameWpf::_()->getModule('options')->get('smtp_pass'));
		}
		return $this->_smtpMailer;
	}
	public function pushPhpMailerError( $errorStr ) {
		if (strpos($errorStr, 'SMTP ERROR') !== false) {
			$this->pushError( $errorStr );
		}
	}
	private function _getSendMailMailer() {
		if (!$this->_sendMailMailer) {
			$this->_connectPhpMailer();
			$this->_sendMailMailer = new PHPMailer();  // create a new object
			$this->_sendMailMailer->isSendmail(); // enable SendMail
			$sendMailPath = trim(FrameWpf::_()->getModule('options')->get('sendmail_path'));
			if (!empty($sendMailPath)) {
				$this->_sendMailMailer->Sendmail = $sendMailPath;
			}
		}
		return $this->_sendMailMailer;
	}
	private function _connectPhpMailer() {
		if (!function_exists('PHPMailerAutoload')) {
			require_once( $this->getModDir() . 'engines' . DS . 'PHPMailerAutoload.php');
		}
	}
	public function sendSendMailMail( $to, $subject, $message, $fromName = '', $fromEmail = '', $replyToName = '', $replyToEmail = '', $additionalHeaders = array(), $additionalParameters = array() ) {
		$this->_getSendMailMailer();
		if ($fromEmail && $fromName) {
			$this->_sendMailMailer->setFrom($fromEmail, $fromName);
		}
		if ($replyToName || $replyToEmail) {
			$this->_sendMailMailer->addReplyTo($replyToName, $replyToEmail);
		}
		$this->_sendMailMailer->Subject = $subject;
		$this->_sendMailMailer->addAddress($to);
		if (FrameWpf::_()->getModule('options')->get('disable_email_html_type')) {
			$this->_sendMailMailer->Body = $message;
		} else {
			$this->_sendMailMailer->msgHTML( $message );
		}
		if ($this->_sendMailMailer->send()) {
			return true;
		} else {
			$this->pushError( 'Mail error: ' . $this->_sendMailMailer->ErrorInfo );
		}
		return false;
	}
	public function sendSmtpMail( $to, $subject, $message, $fromName = '', $fromEmail = '', $replyToName = '', $replyToEmail = '', $additionalHeaders = array(), $additionalParameters = array() ) {
		$this->_getSmtpMailer();
		if ($fromEmail && $fromName) {
			$this->_smtpMailer->setFrom($fromName, $fromName);
		}
		if ($replyToName || $replyToEmail) {
			$this->_smtpMailer->addReplyTo($replyToName, $replyToEmail);
		}
		$this->_smtpMailer->Subject = $subject;
		$this->_smtpMailer->addAddress($to);
		if (FrameWpf::_()->getModule('options')->get('disable_email_html_type')) {
			$this->_smtpMailer->Body = $message;
		} else {
			$this->_smtpMailer->msgHTML( $message );
		}
		if ($this->_smtpMailer->send()) {
			return true;
		} else {
			$this->pushError( 'Mail error: ' . $this->_smtpMailer->ErrorInfo );
		}
		return false;
	}
	public function sendWpMail( $to, $subject, $message, $fromName = '', $fromEmail = '', $replyToName = '', $replyToEmail = '', $additionalHeaders = array(), $additionalParameters = array() ) {
		$headersArr = array();
		$eol = "\r\n";
		if (!empty($fromName) && !empty($fromEmail)) {
			$headersArr[] = 'From: ' . $fromName . ' <' . $fromEmail . '>';
		}
		if (!empty($replyToName) && !empty($replyToEmail)) {
			$headersArr[] = 'Reply-To: ' . $replyToName . ' <' . $replyToEmail . '>';
		}
		if (!function_exists('wp_mail')) {
			FrameWpf::_()->loadPlugins();
		}
		if (!FrameWpf::_()->getModule('options')->get('disable_email_html_type')) {
			add_filter('wp_mail_content_type', array($this, 'mailContentType'));
		}
		
		$attach = null;
		if (isset($additionalParameters['attach']) && !empty($additionalParameters['attach'])) {
			$attach = $additionalParameters['attach'];
		}
		if (empty($attach)) {
			$result = wp_mail($to, $subject, $message, implode($eol, $headersArr));
		} else {
			$result = wp_mail($to, $subject, $message, implode($eol, $headersArr), $attach);
		}
		if (!FrameWpf::_()->getModule('options')->get('disable_email_html_type')) {
			remove_filter('wp_mail_content_type', array($this, 'mailContentType'));
		}

		return $result;
	}
	public function getMailErrors() {
		global $ts_mail_errors;
		global $phpmailer;
		$type = FrameWpf::_()->getModule('options')->get('mail_send_engine');
		switch ($type) {
			case 'smtp':
			case 'sendmail':
				return $this->getErrors();
				break;
			default:
				// Clear prev. send errors at first
				$ts_mail_errors = array();

				// Let's try to get errors about mail sending from WP
				if (!isset($ts_mail_errors)) {
					$ts_mail_errors = array();
				}
				if (isset($phpmailer)) {
					$ts_mail_errors[] = $phpmailer->ErrorInfo;
				}
				if (empty($ts_mail_errors)) {
					$ts_mail_errors[] = esc_html__('Cannot send email - problem with send server', 'woo-product-filter');
				}
				return $ts_mail_errors;
				break;
		}
	}
	public function mailContentType( $contentType ) {
		$contentType = 'text/html';
		return $contentType;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	public function addOptions( $opts ) {
		$opts[ $this->getCode() ] = array(
			'label' => esc_html__('Mail', 'woo-product-filter'),
			'opts' => array(
				'mail_function_work' => array('label' => esc_html__('Mail function tested and work', 'woo-product-filter'), 'desc' => ''),
				'notify_email' => array('label' => esc_html__('Notify Email', 'woo-product-filter'), 'desc' => esc_html__('Email address used for all email notifications from plugin', 'woo-product-filter'), 'html' => 'text', 'def' => get_option('admin_email')),
			),
		);
		return $opts;
	}
}
