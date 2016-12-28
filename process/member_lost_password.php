<?php 
@session_start();
date_default_timezone_set('Asia/Jakarta');
require('../config/nuke_library.php');
require('../config/directory_config.php');
$dateNow = date("Y-m-d H:i:s");
/*Dummy*/
$clean = form_clean($_POST);
$email = $clean['email'];

if($email != ''){
	$jumlah_data 	= num_rows('member','*',"`email` = '$email' AND `status` = 'Active'");
	//$select 		= global_select_single('member','*',"`email` = '$email' AND `status` = 'Active'",false,false,true);
	//print_exit($jumlah_data);
	if($jumlah_data == 1){
		$data 					= global_select_single('member','*',"`email` = '$email'");
		$token_reset 			= create_token();
		$update_token_reset 	= $db->query("UPDATE `member` SET `token_reset` = '$token_reset' WHERE `id` = '".$data['id']."'");
		if($update_token_reset){
			require('../email/member_forgot_password.php');
			$_SESSION['stat']='reset_password_success';
			redirect('/'.$curr_lang.'/index');
		}
	}else{
		$_SESSION['stat']='reset_password_gagal';
		redirect('/'.$curr_lang.'/index');
	}
}else{
	die("error 1");
}
?>