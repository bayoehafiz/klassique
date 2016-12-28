<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('../config/directory_config.php');
$validation = true;

/*save to*/
$save_to_table = "konfirmasi_bayar";

$konfirmasi_bayar['idorder'] 	= filter_var($_POST['idorder'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['nama_bank'] 	= filter_var($_POST['nama_bank'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['atas_nama'] 	= filter_var($_POST['atas_nama'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['norek'] 		= filter_var($_POST['norek'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['transferke'] = filter_var($_POST['transferke'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['nominal'] 	= filter_var($_POST['nominal'],FILTER_SANITIZE_STRING);
$konfirmasi_bayar['tanggal'] 	= filter_var($_POST['tanggal'],FILTER_SANITIZE_STRING);

if($_FILES){
	$rename_to_prefix = ('konfirmasi_order_'.$konfirmasi_bayar['idorder'].'_'.$konfirmasi_bayar['tanggal']);

	foreach ($_FILES as $key => $value) {
		if($value['name'] != ''){
			$konfirmasi_bayar['foto'] = upload_myfile($key,'../uploads_pembayaran/',replace_to_dash($rename_to_prefix));
		}
	}
}

$insert = global_insert("konfirmasi_bayar",$konfirmasi_bayar);
if($insert){

	global_update("order_header",array('status_payment' => 'Waiting'),"id = $konfirmasi_bayar[idorder]");

	$get_tokenpay = global_select_single("order_header","tokenpay","id = $konfirmasi_bayar[idorder]");
	$tokenpay = $get_tokenpay['tokenpay'];
	redirect('/'.$curr_lang."/payment-complete/".$tokenpay);
}
?>