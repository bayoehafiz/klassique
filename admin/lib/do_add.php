<?php 
session_start();
require('../../config/nuke_library.php');
require('resize-class.php');

$table_name 		= $_POST['table_name'];
$redirect_url		= $_POST['redirect_url'];
$upload_folder 	= (isset($_POST['upload_folder']) ? $_POST['upload_folder'] : $GLOBALS['SITE_URL'].'uploads' );

$folder_lib_to_upload_folder = str_replace($GLOBALS['SITE_URL'], "../../", $upload_folder);

$arr_dont_save_me = array(
		'submit',
		'table_name',
		'redirect_url',
		'upload_folder',
		'bgcolor'
	);

if($_POST['submit']){
	$array_data = array();
	
	foreach ($_POST as $key => $value) { #loop array post kedalam $array_data
		if(!in_array($key, $arr_dont_save_me)){
      		$array_data[$key] = $value;
		}
	}

	if($_FILES){
		$rename_to_prefix = (isset($_POST['name']) ? $_POST['name'] : (isset($_POST['title']) ? $_POST['title'] : ""));

		foreach ($_FILES as $key => $value) {
			if($value['name'] != ''){
				$array_data[$key] = upload_myfile($key,$folder_lib_to_upload_folder,replace_to_dash($rename_to_prefix.$key));

				$explode = explode('.',$array_data[$key]);			# get nama directory tanpa extention image
				$ext = get_file_extension($array_data[$key]);		# get extention image
				$nama_setelah_resize = $explode[0];					# get nama setelah resize

				$resizeObj = new resize('../../uploads/'.$array_data[$key]);	# resize class apabila ada

				/*For Classique*/
				if($table_name == 'product_image'){
					$resizeObj -> resizeImage(200,200,'crop');
					$new_name = $nama_setelah_resize.'-200'.'.'.$ext;
					$array_data['image_small'] = $new_name;
					$savedimage = '../../uploads/'.$new_name;
					$resizeObj -> saveImage($savedimage, 80);
				}
			}
		}
	}
 
	$array_data['modified_datetime'] 	= date('Y-m-d H:i:s');
	$array_data['modified_by'] 				= $_SESSION[$SITE_TOKEN.'userID'];
	$array_data['sortnumber'] 				= get_new_sortnumber($table_name);
	/*For Classique*/
	if($table_name == 'news' OR $table_name == 'product_category'){
		$array_data['urlpage'] = replace_to_dash($array_data['title']);
	}
	if($table_name == 'product'){
		$array_data['urlpage'] = replace_to_dash($array_data['name']);
	}

  $insert = global_insert($table_name, $array_data, false);

	if($insert) {
		flash_success("Data berhasil di input");
	} else {
		flash_error("Data tidak berhasil di input");
	}

	redirect($redirect_url);
}

?>