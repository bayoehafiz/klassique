<?php  
require 'smtp_config/PHPMailerAutoload.php';


$a = global_select_single("smtp_setting","*","id=1");
$smtpemail = $a['email'];
$password = $a['password'];
$SMTPsecure = $a['SMTPSecure'];
$port = $a['port'];
$from_subject = $a['from_subject'];
$from_email = $a['from_email'];

/*Seting*/
$mail = new PHPMailer;
$mail->isSMTP();											// Set mailer to use SMTP
$mail->Host = "smtp.gmail.com";								// Specify main and backup SMTP servers
$mail->SMTPAuth = true;										// Enable SMTP authentication
$mail->Username = $smtpemail;								// SMTP username
$mail->Password = $password;								// SMTP password
$mail->SMTPSecure = $SMTPSecure;							// Enable TLS encryption, `ssl` also accepted
$mail->Port = $port;										// TCP port to connect to
$mail->setFrom($from_email, $from);
//$mail->AddCC(trim('info@klassiqueuniform.com'));
?>