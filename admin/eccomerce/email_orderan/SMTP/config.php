<?php  
require 'smtp_config/PHPMailerAutoload.php';

/*Seting*/
$mail = new PHPMailer;
$mail->isSMTP();											// Set mailer to use SMTP
$mail->Host = "smtp.gmail.com";								// Specify main and backup SMTP servers
$mail->SMTPAuth = true;										// Enable SMTP authentication
$mail->Username = 'herman@nukegraphic.com';					// SMTP username
$mail->Password = 'nzkubqdhvowjhocj';						// SMTP password
$mail->SMTPSecure = 'tls';									// Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;											// TCP port to connect to
$mail->setFrom('herman@nukegraphic.com', 'Klassique Desainwebsite Development');
?>