<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$token_login = '';
$validation = true;

if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING);	}

$cek_valid = global_select_single("member","*","token = '".$token_login."'");

if($cek_valid){
	/*Mod*/
	$_POST['publish'] 					= 1;
	$_POST['modified_datetime'] 		= date("Y-m-d h:i:s");

	/*save to*/
	$save_to_table = "product_review";

	/*clean var*/
	$clean = form_clean($_POST);

	$member 							= get_data_member_by_token_login($_SESSION['token_login']);
	$full_name 							= $member['fullname'];
	$array_data['ip_address']			= $_SERVER["REMOTE_ADDR"];
	$array_data['user_name'] 			= $full_name;
	$array_data['rating'] 				= $_POST['score'];  
	$array_data['id_product'] 			= $_POST['id_product'];  
	$array_data['comment'] 				= $_POST['comment'];  
	$array_data['modified_datetime']	= $_POST['modified_datetime'];  
	$array_data['modified_by'] 			= 1;  
	$array_data['publish'] 				= 0;  

	$query = global_insert($save_to_table,$array_data);

	if($query){
		$_SESSION['stat'] = 'review_product_sukses';
		redirect($_SERVER["HTTP_REFERER"]);
	}else{
		die("error-7963ew87ge73few678");
		redirect($_SERVER["HTTP_REFERER"]);
	}
}else{
	$_SESSION['stat'] = "review_harus_login";
	redirect($_SERVER["HTTP_REFERER"]);
}
?>