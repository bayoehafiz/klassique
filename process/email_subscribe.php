<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require "../config/directory_config.php";
$validation = true;
$reff = $_SERVER["HTTP_REFERER"];

/* MAILCHIMP 2.0.6 */
include "inc/Mailchimp.php";
$api_key = "f28bdf68d92b1c5c6cb956cc74f1993d-us12";
$list_id = "faf8022d50";

/*Mod*/
$_POST['publish'] 					= 1;
$_POST['modified_datetime'] 		= date("Y-m-d h:i:s");

/*save to*/
$save_to_table = "email_subscriber";

/*clean var*/
$clean = form_clean($_POST);

if($_POST){
	$clean = form_clean($_POST);
	$email = $clean['email'];

	/*mailchimp code*/
	$Mailchimp = new Mailchimp( $api_key );
	$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
	try {
		$Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($email) ) );
		//echo "success"; exit; ///echo "success";
	
		$_SESSION['stat'] = 'email_subscribe_berhasil';
		log_activity('[<strong>EMAIL SUBSCRIBE</strong>] [SUCESS] | email = '.$array_data['email']);
		redirect($reff);
	} catch(Mailchimp_Error $e) {
	  	//echo 204; exit; //echo 'fail';
	  	//echo $e->getMessage(); // xxx@yyy.com is already subscribed to the list.
	  	//die();

		$_SESSION['stat'] = 'email_subscribe_gagal';
		log_activity('[<strong>EMAIL SUBSCRIBE</strong>] [FAILED] | email = '.$array_data['email']);
		redirect($reff);
		die();
	}
}

?>