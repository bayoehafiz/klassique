<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*clean var*/
$clean = form_clean($_POST);
$from = $_POST['from'];
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
	unset($array_data['from']);
	$query = global_update('member',$array_data,"token = '".$_SESSION['token_login']."'");
	
	if($query){
		if($clean['from'] == 'checkout'){
			redirect('/'.$curr_lang.'/checkout');
		}else{
			$_SESSION['stat'] = 'update_profil_sukses';
			redirect('/'.$curr_lang.'/edit-profile');
		}
	}else{
		die("query salah");
		redirect('/'.$curr_lang.'/edit-profile');
	}
}else{
		echo "c";
}
?>