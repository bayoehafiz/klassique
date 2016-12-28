<?php 
@session_start();
date_default_timezone_set('Asia/Jakarta');
require('../config/nuke_library.php');
require "../config/directory_config.php";
$cryptinstall="../js/crypt/cryptographp.fct.php";
include $cryptinstall;
$validation 	= true;
$dateNow 		= date("Y-m-d H:i:s");
$save_to_table 	= 'contact_list';
$ip_address 	= $_SERVER["REMOTE_ADDR"];
$clean = form_clean($_POST);


if(!chk_crypt($clean['captcha'])){
	$validation = false;
}
unset($clean['captcha']);

/*start Engine*/
if($clean['submit'] && $validation == true){
	foreach ($clean as $key => $value) {
		if($key != 'submit'){
			$array_data[$key] = $value;
		}
		if($key == 'email'){
			$array_data[$key] = strtolower($value);
		}
	}
	
	/*mod*/
	$array_data['ip_address'] 				= $ip_address;
	$array_data['publish'] 					= 1;
	$array_data['modified_datetime'] 		= date("Y-m-d h:i:s");
	$array_data['modified_by'] 				= 1;
	
	$query = global_insert($save_to_table,$array_data);
	
	if($query){
		require('../email/member_contact_us.php');
		$_SESSION['stat']='contact_us_sukses';
		redirect('/'.$curr_lang.'/contact');
	}else{
		die("Error");
	}
}else{
	$_SESSION['stat']='contact_us_gagal';
	redirect('/'.$curr_lang.'/contact');
}
?>