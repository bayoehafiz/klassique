<?php 
require('../config/webconfig-parameters.php');
require 'SMTP/config.php';
@session_start();

$name 		= $_POST['name'];
$email 		= $_POST['email'];
$message 	= $_POST['message'];

/*Mod Variable Email*/
$subject 		= "New Inquiry From Website Klassique";
$title 			= "New Inquiry";
ob_start();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title ;?></title>
<style type="text/css">
	/* ------------------------------------- 
			GLOBAL 
	------------------------------------- */
	* { 
		margin:0;
		padding:0;
	}
	* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

	img { 
		max-width: 100%; 
	}
	body {
		-webkit-font-smoothing:antialiased; 
		-webkit-text-size-adjust:none; 
	}


	/* ------------------------------------- 
			ELEMENTS 
	------------------------------------- */
	a { color: #a3c639;}

	/* ------------------------------------- 
			HEADER 
	------------------------------------- */

	.header.container table td.logo { padding: 15px; }
	.header.container table td.label { padding: 15px; padding-left:0px;}


	/* ------------------------------------- 
			FOOTER 
	------------------------------------- */
	table.footer-wrap { clear:both!important;
	}
	.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
	.footer-wrap .container td.content p {
		font-size:10px;
		font-weight: bold;
		
	}

	/* ------------------------------------- 
			TYPOGRAPHY 
	------------------------------------- */
	h1,h2,h3,h4,h5,h6 {
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
	}
	h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

	h1 { font-weight:200; font-size: 44px;}
	h2 { font-weight:200; font-size: 37px;}
	h3 { font-weight:500; font-size: 27px;}
	h4 { font-weight:500; font-size: 23px;}
	h5 { font-weight:900; font-size: 17px;}
	h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

	p, ul, ol { 
		margin-bottom: 10px; 
		font-weight: normal; 
		font-size:14px; 
		line-height:1.6;
	}
	p.lead { font-size:17px; }
	p.last { margin-bottom:0px;}

	ul li, ol li {
		margin-left:5px;
		list-style-position: inside;
	}


	/* --------------------------------------------------- 
			RESPONSIVENESS
			Nuke it from orbit. It's the only way to be sure. 
	------------------------------------------------------ */

	/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
	.container {
		display:block!important;
		max-width:600px!important;
		margin:0 auto!important; /* makes it centered */
		clear:both!important;
	}

	/* This should also be a block element, so that it will fill 100% of the .container */
	.content {
		padding:15px;
		max-width:600px;
		margin:0 auto;
		display:block; 
	}

	/* ------------------------------------------- 
			PHONE
			For clients that support media queries.
			Nothing fancy. 
	-------------------------------------------- */
	@media only screen and (max-width: 600px) {
		
		a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

		div[class="column"] { width: auto!important; float:none!important;}

	}
</style>

</head>
 
<body bgcolor="#FFFFFF" style="width:100%;height:100%">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#fff" width="100%">
	<tr>
		<td></td>
		<td class="header container">
			
			<table bgcolor="#fff">
				<tr>
					<td style="padding:15px 15px 0 15px;">
						<a href="<?php echo $website_config ?>" target="_blank">
							<img src="<?php echo $SITE_URL ?>uploads/<?php echo $logo_config ?>" width="200px"/>
						</a>
					</td>
				</tr>
			</table>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap" width="100%">
	<tr>
		<td></td>
		<td class="container">

			<div class="content">
			<table width="100%">
				<tr>
					<td>
						
						<!-- A Real Hero (and a real human being) -->
						
						
						<h3 style="font-size:16px; font-weight:bold;">Dear <span style="color:#a3c639">Customers</span>, You have new Inquiry</h3>

						<table cellpadding="0" cellspacing="0" >
							<tr>
								<td>
									 <table cellpadding="0" cellspacing="0" border="0" id="white-wrap" bgcolor="#ffffff" style="margin-bottom:10px;" width="700px;">
										<tr>
											<td>   
												<p><hr style="border:1px solid #ccc;" /></p>

												<p> Full Name 		: <strong><?php echo $name;?></strong></p>   
												<p> Email	 		: <?php echo $email;?></p> 
												<p> message 		: <?php echo $message;?></p>

												<p><hr style="border:1px solid #ccc;" /></p>  
												
											</td>
										</tr>
									</table><!-- #white-wrap -->  
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</div>
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->


<!-- social & contact -->
<table class="social" width="100%">
	<tr>
		<td class="container">
			<div class="content">
				<table width="100%">
					<tr>
						<td style="width:200px;">
							<a href="<?php echo $website_config ?>" target="_blank"><img src="<?php echo $SITE_URL ?>uploads/<?php echo $logo_config ?>" width="165" height="auto"></a>
						</td>
						<td style="width:50px; padding-left:10px;">
							<p style="font-size:11px; margin-bottom:0; color:#777777;">Address :</p>
							<p style="font-size:11px; margin-bottom:0; color:#777777;"><?php echo $address_config ?></p>
							<br/>									
							<table width="100%">
								<tr>
									<td><p style="font-size:11px; margin-bottom:0; color:#777777;">Phone : <a href="tel:<?php echo $phone_config ?>" style="color:#a3c639"><?php echo $phone_config ?></a></p></td>
									<td><p style="font-size:11px; margin-bottom:0; color:#777777;">Email : <a href="mailto:<?php echo $email_config ?>" style="color:#a3c639"><?php echo $email_config ?></a></p></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table><!-- /social & contact -->

<table class="footer-wrap" bgcolor="#a3c639" width="100%">
	<tr>
		<td class="container">
			<div class="content">
				<table width="100%">
					<tr>
						<td style="padding:0 15px;">
							<a href="<?php echo $facebook_config ?>"><img style="float:left;margin-right:10px;" src="<?php echo $SITE_URL ?>email/images/icon-facebook.png"> </a>
							<a href="<?php echo $facebook_config ?>" style="color:#fff !important; font-size:13px; display:inline-block; padding:4px 0; text-decoration:none">
								<?php echo $facebook_config ?>
							</a>
						</td>
						<td style="padding:0 15px;">
							<a href="<?php echo $twitter_config ?>"><img style="float:left;margin-right:10px;" src="<?php echo $SITE_URL ?>email/images/icon-twitter.png"></a>
							<a href="<?php echo $twitter_config ?>" style="color:#fff !important; font-size:13px; display:inline-block; padding:4px 0; text-decoration:none">
								@<?php echo $twitter_config ?>
							</a>
						</td>
						<td style="padding:0 15px;">
							<a href="<?php echo $instagram_config ?>"><img style="float:left;margin-right:10px;" src="<?php echo $SITE_URL ?>email/images/icon-instagram.png"></a>
							<a href="<?php echo $instagram_config ?>" style="color:#fff !important; font-size:13px; display:inline-block; padding:4px 0; text-decoration:none">
								@<?php echo $instagram_config ?>
							</a>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<!-- FOOTER -->
<table class="footer-wrap" width="100%">
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
				<table width="100%">
					<tr>
						<td align="center">
							<p style="font-size:11px; margin-bottom:0; color:#777777;">
								<!-- You receive this email because you sign up on our website or made purchase form us. Your address is listed as emailnam@gmail.com. Please let us know if you wish ti <a href="">unsubscribe</a> from this list. -->
							</p>
						</td>
					</tr>
				</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
				<table width="100%">
					<tr>
						<td align="center">
							<p style="font-size:11px; margin-bottom:0; color:#777777;">
								Copyright &copy; 2015 <?php echo $name_config ?>. All right reserved.
							</p>
						</td>
					</tr>
				</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>

<?php
$message = ob_get_clean();

//$mail->AddCC("ranto@nukegraphic.com");	
$mail->addAddress("herman@nukegraphic.com");
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->msgHTML($message);

if(!$mail->send()) {
	//echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	die();
} else {
	echo 'Message has been sent';
}
?>