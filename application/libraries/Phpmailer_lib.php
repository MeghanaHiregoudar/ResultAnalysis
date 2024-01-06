<?php
defined('BASEPATH') or exit('No direct access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Phpmailer_lib 
{
	public function __construct()
	{
		 log_message('Debug', 'PHPMailer class is loaded.');
	}

	public function load()
	{
		require_once APPPATH.'third_party/PHPMailer/src/Exception.php';
		require_once APPPATH.'third_party/PHPMailer/src/PHPMailer.php';
		require_once APPPATH.'third_party/PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure ='tls';
		$mail->Port = 587;
		$mail->Host = 'smtp.gmail.com';
		$mail->username = 'meghana62558@gmail.com';
		$mail->password = 'Meghana@123';
		$mail->isHTML(true);
		return $mail;
	}


} ?>