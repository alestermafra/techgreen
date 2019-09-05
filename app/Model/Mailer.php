<?php

require APP . DS . 'lib' . DS . 'PHPMailer' . DS . 'PHPMailer.php';
require APP . DS . 'lib' . DS . 'PHPMailer' . DS . 'SMTP.php';
require APP . DS . 'lib' . DS . 'PHPMailer' . DS . 'Exception.php';

class Mailer {
	
	private $mailer = null;
	
	public $template = null;
	
	public function __construct($config = null) {
		$this->mailer = new PHPMailer\PHPMailer\PHPMailer();
		$this->mailer->isSMTP();
		$this->mailer->SMTPDebug = 2;
		$this->mailer->SMTPAuth = true;
		$this->mailer->Port = 80;
		$this->mailer->isHTML(true);
		$this->mailer->CharSet = 'UTF-8';
		
		if($config) {
			config('email');
			$config = EmailConfig::${$config};
			$this->applyConfig($config);
		}
	}
	
	public function applyConfig($config = null) {
		if(isset($config['host'])) {
			$this->host($config['host']);
		}
		if(isset($config['username'])) {
			$this->username($config['username']);
		}
		if(isset($config['password'])) {
			$this->password($config['password']);
		}
		if(isset($config['from'])) {
			$this->from($config['from']);
		}
		if(isset($config['template'])) {
			$this->template($config['template']);
		}
		if(isset($config['to'])) {
			$this->to($config['to']);
		}
		if(isset($config['cc'])) {
			$this->cc($config['cc']);
		}
		if(isset($config['bcc'])) {
			$this->bcc($config['bcc']);
		}
		if(isset($config['subject'])) {
			$this->subject($config['subject']);
		}
		if(isset($config['attachment'])) {
			$this->attachment($config['attachment']);
		}
	}
	
	public function host($host = null) {
		$field = &$this->mailer->Host;
		if($host) {
			$field = $host;
		}
		return $field;
	}
	
	public function username($username = null) {
		$field = &$this->mailer->Username;
		if($username) {
			$field = $username;
		}
		return $field;
	}
	
	public function password($password = null) {
		$field = &$this->mailer->Password;
		if($password) {
			$field = $password;
		}
		return $field;
	}
	
	public function from($from) {
		if(is_array($from)) {
			foreach($from as $k => $v) {
				$this->mailer->setFrom($k, $v);
				break;
			}
		}
		else {
			$this->mailer->setFrom($from);
		}
	}
	
	public function to($to) {
		if(is_array($to)) {
			foreach($to as $k => $v) {
				$this->mailer->addAddress($k, $v);
			}
		}
		else {
			$this->mailer->addAddress($to);
		}
	}
	
	public function cc($cc) {
		if(is_array($cc)) {
			foreach($cc as $k => $v) {
				$this->mailer->addCC($k, $v);
			}
		}
		else {
			$this->mailer->addCC($cc);
		}
	}
	
	public function bcc($bcc) {
		if(is_array($bcc)) {
			foreach($bcc as $k => $v) {
				$this->mailer->addBCC($k, $v);
			}
		}
		else {
			$this->mailer->addBCC($bcc);
		}
	}
	
	public function subject($subject = null) {
		$field = &$this->mailer->Subject;
		if($subject) {
			$field = $subject;
		}
		return $field;
	}
	
	public function body($body = null) {
		$field = &$this->mailer->Body;
		if($body) {
			$field = $body;
		}
		return $field;
	}
	
	public function attachment($attachment) {
		if(is_array($attachment)) {
			foreach($attachment as $attach) {
				$this->mailer->addAttachment($attach);
			}
		}
		else {
			$this->mailer->addAttachment($attachment);
		}
	}
	
	public function template($template) {
		$this->template = $template;
	}
	
	public function send($vars = null) {
		if($this->template) {
			$view = new View();
			if($vars) {
				foreach($vars as $k => $v) {
					$view->set($k, $v);
				}
			}
			$this->body($view->email($this->template));
		}
		
		return $this->mailer->send();
	}
}