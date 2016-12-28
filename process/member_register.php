<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*Mod*/
$_POST['publish'] 					= 1;
$_POST['token'] 					= create_token();
$_POST['modified_datetime'] 		= date("Y-m-d h:i:s");

/*save to*/
$save_to_table = "member";

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

$check_duplicate = global_select_single("member","*","`email` LIKE '%$clean[email]%'");
if(isset($check_duplicate['id'])){
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
	$array_data['password'] = md5(md5(sha1($clean['password'])));
	$array_data['status'] = 'Not Active';
	$query = global_insert($save_to_table,$array_data);

	if($query){
		/*Add Log  BERHASIL REGISTER */ 
		log_activity('[<strong>REGISTRATION</strong>] [SUCESS] | idmember = '.$query.' | fullname ='.$array_data['fullname'].' | email = '.$array_data['email']);

		$data_member = global_select_single("member","*","id = $query");
		$_SESSION['token_login'] = $data_member['token'];
		require('../email/member_register.php');
		$_SESSION['stat'] = 'member_need_to_activate_account';
		redirect('/'.$curr_lang.'/index');
	}else{
		/*Add Log GAGAL*/ 
		log_activity('[<strong>REGISTRATION</strong>] [FAILED] | fullname ='.$clean['fullname'].' | email = '.$clean['email']);
		redirect('/'.$curr_lang.'/edit-profile');
	}
}else{
	/*Add Log DUPLIKAT DATA*/ 
	$_SESSION['stat'] = 'member_data_already_registered';
	log_activity('[<strong>REGISTRATION</strong>] [DUPLICATE DATA] | fullname ='.$clean['fullname'].' | email = '.$clean['email']);
	redirect('/'.$curr_lang.'/index');
}?>