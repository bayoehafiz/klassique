<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*validate*/
if( (!isset($_POST['email']) AND $_POST['email'] == '') AND (!isset($_POST['password']) AND $_POST['password'] == '') ){
	$validation = false;
}

/*clean var*/
$clean = form_clean($_POST);

if(isset($clean['from'])){unset($clean['from']);}
/*start engine*/
if($validation == true){
	$check_member = global_select_single("member","*","`email` = '$clean[email]' AND `password` = '".md5(md5(sha1($clean['password'])))."' AND `status` = 'Active'");
}else{
	die("validation error");
}

/*done*/
if($check_member){
	/*Add Log*/ 
	$_SESSION['token_login'] = $check_member['token'];
	log_activity('[<strong>LOGIN</strong>] [SUCESS] | email ='.$clean['email']);
	
	if(isset($_POST['from']) AND  $_POST['from'] == 'checkout' ){
		$member = get_data_member_by_token_login($_SESSION['token_login']);
		$idkota = $member['idkota'];
		if($idkota){
			$cek_ongkir = global_select_single("ongkir","*","id = $idkota");
			$ongkir = $cek_ongkir['ongkir'];
			$_SESSION['ongkir'] = $ongkir;
			
		}
		redirect('/'.$curr_lang.'/checkout');
	}else{
		redirect('/'.$curr_lang.'/edit-profile');
	}
}else{
	/*Add Log*/ 
	$_SESSION['stat'] = 'member_login_failed';
	log_activity('[<strong>LOGIN</strong>] [FAILED] | email ='.$clean['email']);
	redirect('/'.$curr_lang.'/index');
}
?>