<?php
/**
 * 发送邮件
 * @author zouhao
 */
class Mail{
	private $mail=null;
	public function __construct(){
		require LIBRARY_PATH.'/PHPMailer/class.phpmailer.php';
		$this->mail=new PHPMailer();
		$this->mail->IsSMTP();
		$this->mail->Host=C('MAIL_HOST');
		$this->mail->SMTPAuth = true;
		$this->mail->Username=C('MAIL_USERNAME');
		$this->mail->Password=C('MAIL_PASSWORD');
		$this->mail->From=C('MAIL_USERNAME');
		$this->mail->FromName=C('MAIL_FROMNAME');
		$this->mail->CharSet='utf-8';
		$this->mail->Encoding='base64';
		$this->mail->AltBody='text/html';
		$this->mail->IsHTML(true);
	}
	public function send($recive,$subject,$body){
		$this->mail->AddAddress($recive);
		$this->mail->Subject=$subject;
		$this->mail->Body=$body;
		return $this->mail->Send();
	}
}