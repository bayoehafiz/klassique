<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*clean var*/
$clean = form_clean($_POST);
$password_lama = md5(md5(sha1($clean['password1'])));
$data_member = get_data_member_by_token_login($_SESSION['token_login']);

if($data_member['password'] != $password_lama){
	$validation = false;
}

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
	unset($array_data['password1']);
	unset($array_data['password2']);
	unset($array_data['password3']);
	$array_data['password'] = md5(md5(sha1($clean['password2'])));
	$query = global_update('member',$array_data,"token = '".$_SESSION['token_login']."'");
	
	if($query){
		$_SESSION['stat'] = "ganti_password_sukses";
		redirect('/'.$curr_lang.'/change-password');
	}else{	
		redirect('/'.$curr_lang.'/change-password');
		die("error-29863w8756876t3876t387697");
	}
}else{
	$_SESSION['stat'] = "ganti_password_gagal";
	redirect('/'.$curr_lang.'/change-password');
	die("error-867834e76r4e79i6ry4e");
}
?>