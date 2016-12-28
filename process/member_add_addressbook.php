<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

$member_login = global_select_single("member","id","token= '".$_SESSION['token_login']."'");
$id_member = $member_login['id'];

/*Mod*/
$_POST['publish'] 					= 1;
$_POST['modified_datetime'] 		= date("Y-m-d h:i:s");

/*save to*/
$save_to_table = "member_addressbook";

/*clean var*/
$clean = form_clean($_POST);

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
	unset($array_data['submit']);
	$array_data['id_member'] = $id_member;
	$query = global_insert($save_to_table,$array_data);
	
	if($query){
		redirect('/'.$curr_lang.'/address-book');
		die("Done. tinggal set redirect");
	}else{
		redirect('/'.$curr_lang.'/edit-profile');
		die("Gagal. Error save");
	}
}else{
	die("no submit Or Duplicate Data");
}
?>