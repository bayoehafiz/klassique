<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*clean var*/
$clean = form_clean($_POST);

/*validation*/
if($clean['password1'] != $clean['password2']){
	$validation = false;
}else{
	$validation = true;
	$clean['password'] = $clean['password1'];
	unset($clean['password1']);
	unset($clean['password2']);
}

	$array_data['password'] = md5(md5(sha1($clean['password'])));
	$query = global_update("member",$array_data,"token_reset = '".$_SESSION['token_reset']."'");
	if($query){
		$_SESSION['stat'] = 'restore_password_sukses';
		redirect('/'.$curr_lang.'/index');
	}else{
		die("error-sklsdgew3kui768gi");
	}
?>