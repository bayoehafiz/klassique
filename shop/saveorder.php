<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require("../config/directory_config.php");
require('shopcart-table.php');

$_POST['order_amount'] = total_amount_cart($_SESSION['token_shopcart']); 

$data_member = get_data_member_by_token_login($_SESSION['token_login']);

$token_pay = create_token();

$biaya_ongkir = 0;
$diskon_voucher = 0;
$berat = 0;
$vouchercode = '';
if(isset($_SESSION['ongkir'])){
	//$berat = total_berat($_SESSION['token_shopcart']);
	$biaya_ongkir = $_SESSION['ongkir'] * $_SESSION['berat'];
}
if(isset($_SESSION['voucher']['discount_value'])){
	$vouchercode = $_SESSION['voucher']['code'];
	$diskon_voucher = $_SESSION['voucher']['discount_value'];
}

if($_POST['shipping_address'] == 'shipping_address'){
	$nama_penerima = $data_member['fullname'];
	$phone_penerima = $data_member['phone'];
	$address_penerima = $data_member['address'];
	$country_penerima = $data_member['country'];
	$provinsi_penerima = $data_member['propinsi'];
	$kabupaten_penerima = $data_member['kabupaten'];
	$kota_penerima = $data_member['idkota'];
	$kodepos = $data_member['kodepos'];
}else{
	$split = explode('#',$_POST['shipping_address']);
	$id_addressbook = $split[1];
	$addressbook = global_select_single("member_addressbook","*","id = $id_addressbook");

	$nama_penerima = $addressbook['receiver_name'];
	$phone_penerima = $addressbook['phone_number'];
	$address_penerima = $addressbook['address'];
	$country_penerima = $addressbook['country'];
	$provinsi_penerima = $addressbook['propinsi'];
	$kabupaten_penerima = $addressbook['kabupaten'];
	$kota_penerima = $addressbook['idkota'];
	$kodepos = $addressbook['kodepos'];
}

$header['date']						= date("Y-m-d h:i:s");
$header['idmember']					= $data_member['id'];
$header['idbank']					= $data_member['id'];
$header['payment_metod']			= $_POST['payment_method'];
$header['orderamount'] 				= total_amount_cart($_SESSION['token_shopcart']);
$header['shippingcost'] 			= $biaya_ongkir;
$header['discountamount'] 			= $diskon_voucher;
$header['status_payment']			= "Pending On Payment";
$header['status_delivery']			= "Pending On Delivery";
$header['note']						= filter_var($_POST['shipping_note'],FILTER_SANITIZE_STRING);
$header['kurir']					= $_POST['kurir'];
$header['resinumber']				= '';
$header['vouchercode']				= $vouchercode;
$header['nama_penerima']			= $nama_penerima;
$header['phone_penerima']			= $phone_penerima;
$header['address_penerima']			= $address_penerima;
$header['country_penerima']			= $country_penerima;
$header['provinsi_penerima']		= $provinsi_penerima;
$header['kabupaten_penerima']		= $kabupaten_penerima;
$header['kota_penerima']			= $kota_penerima;
$header['tokenpay']					= $token_pay;
$header['bca_tokenid']				= '';
$header['kode_trxno_klikpay1']		= '';
$header['kode_trxno_klikpay2']		= '';
$header['kode_unik']				= '';
$header['konfirmasi_bayar_byadmin']	= '';
$header['tanggal_konfirmasi']		= '';
$header['konfirmasi_kirim_byadmin']	= '';
$header['tanggal_konfirmasi_kirim']	= '';


$insert_header = global_insert("order_header",$header);

if($insert_header){
	$shopcart_detail = global_select("shopcart_detail","*","token_head = '$_SESSION[token_shopcart]'");
	foreach ($shopcart_detail as $key => $value) {
		
		if($value['id_product_detail'] == 0){
			redirect($_SERVER['HTTP_REFERER']);
		}

		$data_product = global_select_single("product","*","id = $value[id_product]");

		$data_detail_product = global_select_single("product_detail_size","*","id = $value[id_product_detail]");

		$detail['tokenpay'] 		= $token_pay;
		$detail['idproduct'] 		= $value['id_product'];
		$detail['sku'] 				= $data_product['sku'];
		$detail['iddetail']			= $value['id_product_detail'];
		$detail['name']				= $value['product_name'].' ('.get_gender_from_id($data_detail_product['gender'],'product_gender').')';
		$detail['nama_detail']		= get_fit_from_id($data_detail_product['fit_type'],'product_type').',Merah#'.get_size_from_id($data_detail_product['size'],"product_size");
		$detail['qty']				= $value['qty'];
		$detail['price']			= get_harga_product_order_detail($value['id_product'],$value['is_custom'],$value['custom_line1'],$value['custom_line2'],$value['custom_gambar']);
		$detail['is_custom']		= $value['is_custom'];
		$detail['custom_line1']		= $value['custom_line1'];
		$detail['custom_line2']		= $value['custom_line2'];
		$detail['base64']			= $value['base_encode'];
		$detail['custom_gambar']	= $value['custom_gambar'];
		$detail['posisi_gambar']	= $value['gambar_posisi'];
		$detail['style_line1']		= $value['style_line1'];
		$detail['style_line2']		= $value['style_line2'];

		if( $value['qty'] <= $data_detail_product['stock']){
			$update_qty_detail = $data_detail_product['stock'] - $value['qty'];
			$insert_detail = global_insert("order_detail",$detail);
			$update_qty = global_update("product_detail_size",array("stock" => $update_qty_detail),"id = $data_detail_product[id]");
		}else{
			global_delete("order_header","id = $insert_header");
			$_SESSION['stat'] = 'checkout_stok_habis';
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}

if($insert_detail){
	unset($_SESSION['token_shopcart']);
	unset($_SESSION['voucher']);
	$emailmember = $data_member['email'];
	$membername = $data_member['fullname'];
	$idorder 	= $insert_header;
	
	$grandTotal = $header['orderamount'];
	$ongkirPrice = $header['shippingcost'];
	$totalfixorder = $header['orderamount'] + $header['shippingcost'] - $header['discountamount'];
	$notemember = $header['note'];
	$kurir_namaid = $header['kurir'];
	$payment_metod = $header['payment_metod'];
	$alamatKirim = $header['address_penerima'];
	$diskonPrice = $header['discountamount'];
	$kodevoucheridtext = $header['vouchercode'];
	require('../email/order_email_member.php');
	$db->query("UPDATE `voucher` SET `max_used` = `max_used` - 1 WHERE `code` = '$vouchercode'");
	
	if($header['payment_metod'] == 'Online Payment'){
		$_SESSION['tokenorderidmember'] = $header['tokenpay'];

		$_SESSION['data_member']['alamat'] = $alamatKirim;
		$_SESSION['data_member']['idkota'] = $kota_penerima;
		$_SESSION['data_member']['kabupaten_penerima'] = $kabupaten_penerima;
		$_SESSION['data_member']['kodepos'] = $kodepos;
		redirect('/veritrans-step2/');
		die();
	}
	
	redirect('/'.$curr_lang.'/order-complete/'.$detail['tokenpay'].'/');
}?>