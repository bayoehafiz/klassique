<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*validate*/
if( !isset($_GET['token'])){
	$validation = false;
}

$token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);

/*start engine*/
if($validation == true){
	$check_member = global_select_single("member","*","`token` = '$token'");
}else{
	die("validation error");
}

/*done*/
if($check_member){

	$update_status = global_update("member",array('status' => 'Active'),"token = '$token'");	
	
	if($update_status){
		$_SESSION['stat'] = "member_aktivasi_sukses";
		redirect('/'.$curr_lang.'/edit-profile');
		die();
	}else{
		die("error-3262162189");
	}
}else{
	
	$_SESSION['stat'] = "member_aktivasi_gagal";
	redirect('/'.$curr_lang.'/index');
	die();
}
?>