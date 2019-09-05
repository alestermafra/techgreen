<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');
App::import('Emailer', 'Model');
App::import('Mailer', 'Model');

class MailerController extends AppController {
	
	public $layout = false;
	public $autoRender = false;
	
	public function beforeAction() {
		Auth::allow(array('index', 'sendNext'));
		parent::beforeAction();
	}
	
	public function index() {
		echo 'remote_addr: ' . $_SERVER['REMOTE_ADDR'];
		echo '<br />';
		echo 'gethostname: '. gethostname();
		echo '<br />';
		echo 'gethostbyname: '. gethostbyname(gethostname());
		echo '<br />';
		die();
		$mailer = new Mailer('default');
		$mailer->to('alester.mafra@mindgold.com.br');
		$mailer->body('Testando email');
		//$mailer->to('bruce.roberto@mindgold.com.br');
		//$mailer->to(array('bruce.roberto@mindgold.com.br' => 'Bruceta'));
		//$mailer->subject('Teste E-mail');
		
		//$mailer->host('smtpout.secureserver.net');
		//$mailer->username('alester.mafra@mindgold.com.br');
		//$mailer->password('123mudar');
		//$mailer->from(array('alester.mafra@mindgold.com.br' => 'Alester Mafra'));
		//$mailer->to(
		//	array(
		//		'bruce.roberto@mindgold.com.br' => 'bruceta'
		//	)
		//);
		//$mailer->subject('Teste Email');
		//$mailer->template('teste2');
		
		echo $mailer->send();
		//$mailer = new PHPMailer\PHPMailer\PHPMailer(true);
		//
		//try {
		//	$mailer->SMTPDebug = 2;
		//	$mailer->isSMTP();
		//	$mailer->Host = 'smtpout.secureserver.net';
		//	$mailer->SMTPAuth = true;    
		//	$mailer->Username = 'alester.mafra@mindgold.com.br';
		//	$mailer->Password = '123mudar';
		//	
		//	$mailer->setFrom('alester.mafra@mindgold.com');
		//	$mailer->addAddress('reetsr2@gmail.com', 'Bruceta');
		//	
		//	$mailer->isHTML(true);
		//	
		//	$mailer->Subject = 'Teste e-mail';
		//	
		//	$mailer->Body    = 'This is the HTML message body <b>in bold!</b>';
		//	$mailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
		//	$mailer->send();
		//}
		//catch(Exception $e) {
		//	echo "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}";	
		//}
	}
	
	public function sendNext() {
		$email = Emailer::nextMail();

		if($email) {
			$mailer = new Mailer('default');
			$mailer->to($email['para']);
			if($email['ccopia']) {
				$mailer->cc($email['ccopia']);
			}
			$mailer->subject($email['assunto']);
			$mailer->body($email['corpo']);
			
			$ret = $mailer->send();
			
			if($ret) {
				Emailer::enviado($email['cmailer'], 1);
			}
			else {
				Emailer::enviado($email['cmailer'], 2);
			}
		}
	}
}