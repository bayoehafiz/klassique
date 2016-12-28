<?php   
require 'SMTP/config.php';
@session_start();
$subject = 'KLASSIQUE Development';

$body = '
<body style="font-family: \'Segoe UI\', Calibri, Arial, Helvetica, sans-serif; font-size:14px; line-height:1.5em; color:#000;">
	<table width="600" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Segoe UI\', Calibri, Arial, Helvetica, sans-serif; border:10px solid #ecebeb;">
		<tr>
			<td style="padding:30px 50px;">
				Ini testing mail SMTP Dari Lokal
			</td>
		</tr>
	</table >
</body>';


$mail->setFrom('herman@nukegraphic.com', 'Lokal PC');
$mail->addAddress('eshardd@gmail.com');			// Add a recipient
//$mail->AddCC("ranto@nukegraphic.com");	
$mail->isHTML(true);										// Set email format to HTML
$mail->Subject = $subject;
$mail->msgHTML($body);

if(!$mail->send()) {
	//echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	die();
} else {
	echo 'Message has been sent';
}
?>