<?php 
	//config goes here
	$config_query = $db->query("SELECT * FROM `web_config`");
	$row_config = $config_query -> fetch_array();

	$nameconfig 		= $row_config['name'];
	$namewebsite 		= $row_config['website_name'];
	$emailconfig		= $row_config['email'];
	$picconfig			= $row_config['logo_image'];
		
	$inquiry_subject	= 'New inquiry from your website';
	$inquiry_text		= 'There is one new inqury from your website, please review the information below';	
	$orderemailmember   = "Order Notification On Mizuno Indonesia";
	$ordecanceltext     = "Order Cancel Notification On ".$nameconfig." ";
	$confirmemailtext   = "Order Confrimed Notification On ".$nameconfig." ";
	$confirmemailtext_deli	= "Order Delivery Notification On ".$nameconfig." ";

	$registeremail_text = 'Registration Notification On '.$nameconfig.' ';
	$resetpassid_text = 'We\'ve resetted your password On '.$nameconfig.' ';
	
		
	//EMAIL SUBJECT FOR EMAIL SENDING SYSTEM
	$email_from			= 'From: '.$nameconfig.' <donotreply@mizuno.com>';
 ?>