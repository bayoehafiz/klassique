<?php 
$config_query = $db->query("SELECT * FROM `web_config` WHERE `id`=1") or die(mysql_error());
$row_config = $config_query->fetch_assoc();

$email_config			= $row_config['email']; 
$name_config			= $row_config['name'];
$logo_config			= $row_config['logo_image'];
$website_config			= $row_config['website'];
$address_config 		= $row_config['company_address'];
$phone_config			= $row_config['phone'];
$fax_config				= $row_config['fax'];
$whatsapp_config		= $row_config['whatsapp'];
$facebook_config		= $row_config['facebook_link'];
$twitter_config			= $row_config['twitter_link'];
$linkedin_config		= $row_config['linkedin_link'];
$instagram_config		= $row_config['instagram_link'];
?>