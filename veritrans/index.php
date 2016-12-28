<?php
@session_start();

require('../config/connection.php');
include_once('veritrans-php-master/Veritrans.php');



function gb_queryall($table_name, $str_select, $str_where=false, $str_order=false) {
		global $db;
		$str = " SELECT ".$str_select." FROM `".$table_name."` 
			   ".($str_where ? "WHERE ".$str_where : "")."
		   	   ".($str_order ? "ORDER BY ".$str_order : "")." ";
	
		$result = $db->query($str);
		$jumpage = $result->num_rows;
		if($jumpage > 0):
			$arr_return_data = array();
			while($row = $result->fetch_assoc()):
				array_push($arr_return_data, $row);
			endwhile;
			
			return $arr_return_data;
		 endif;
	
		return false;
}

function getnamegeneral($iddata,$fieldid,$act,$field){
	global $db;
	$query = $db->query("SELECT `".$field."` FROM `".$act."` WHERE `".$fieldid."` = '$iddata' ");
	$row = $query->fetch_assoc();
	return ucwords($row[$field]);	
}

function getnamakota($id){
	global $db;
	$query = $db->query("SELECT `nama_kota` FROM `ongkir` WHERE `id`='$id'");
	$res = $query->fetch_assoc();
	return ucwords($res['nama_kota']);
}


//token member--
if(isset($_SESSION['tokenorderidmember'])): $tokenid = $_SESSION['tokenorderidmember']; else: $tokenid = ''; endif;

//member data---
if(isset($_SESSION['token_login'])){
	$Usertokenid = $_SESSION['token_login']; 
}else{
	$Usertokenid = '';
}
	
$quepmm = $db->query("SELECT * FROM `member` WHERE `token`='$Usertokenid'");
$datamember = $quepmm->fetch_assoc();	

//member
$idmember 				= $datamember['id'];
$namamenber 			= $datamember['fullname'];
$emailmember 			= $datamember['email'];
$member_phone 			= $datamember['handphone'];

$shipp_address_member 	= $_SESSION['data_member']['alamat'];
$idkotamember 			= $_SESSION['data_member']['idkota'];
$namakota_member 		= getnamakota($idkotamember);
$namakabupaten_member 	= $_SESSION['data_member']['kabupaten_penerima'];
$kodeposmember 			= $_SESSION['data_member']['kodepos'];
if($kodeposmember =="" ){
	$koddepos = "0000"; 
}else{
	$koddepos = $kodeposmember;
}

//order header
$queryodr = $db->query("SELECT * FROM `order_header` WHERE `idmember`='$idmember' and `tokenpay`='$tokenid' ");
$res = $queryodr->fetch_assoc();

//order header--
$totalordermember = ( ($res['orderamount']+$res['shippingcost']+$res['kode_unik']) - $res['discountamount'] );

$orederidmm 			= sprintf('%06d',$res['id']);
$Shipongkir 			= $res['shippingcost'];
$nama_penerima 			= $res['nama_penerima'];
$phone_penerima 		= $res['phone_penerima'];
$shipp_address 			= $res['address_penerima'];
$namakota 				= $res['kota_penerima'];
$namakabupaten 			= $res['kabupaten_penerima'].', '.$res['provinsi_penerima'];
if($datamember['kodepos']==""):
	$kodepos = '0000';
else:
	$kodepos = $datamember['kodepos'];
endif;


// Set our server key
Veritrans_Config::$serverKey = 'VT-server-XEY4elEDDRuQs6yuz92mt6Jn';

// Use sandbox account
Veritrans_Config::$isProduction = true; // true or false

// Uncomment to enable sanitization
Veritrans_Config::$isSanitized = true;

// Uncomment to enable 3D-Secure
Veritrans_Config::$is3ds = true;



// Required
$transaction_details = array(
  'order_id' => $orederidmm,
  'gross_amount' => $totalordermember,
);



//set item list
$items_details = array();


//order detail----
$datalisprod = gb_queryall("order_detail", "*", "`tokenpay`='$tokenid'", "`id` ASC");
$nomneruid = 1; $prodname = ''; $prodnameList = '';

foreach($datalisprod as $key => $val){

	$idproduct = $val['idproduct'];
	$itemwarnalist = explode("#",$val['nama_detail']);
	$warnaprod = $itemwarnalist[0];
	$EURsize = $itemwarnalist[1];								
	$prodname = $val['name'].' - '.$warnaprod.' ('.$EURsize.')';
	$prodnameList = substr($prodname,0,50);
	$harga_gambar = 0;
		
	if($val['base64'] != ''){
		$query_get_harga_gambar = $db->query("SELECT * FROM `product` WHERE `id`='$idproduct'");
		$fetch_get_harga_gambar = $query_get_harga_gambar->fetch_assoc();
		$harga_gambar = $fetch_get_harga_gambar['price_custom_gambar'];
	}
	$item_dataorder[$key] = array(
		'id' => $nomneruid,
		'price' => $val['price']+$harga_gambar,
		'quantity' => $val['qty'],
		'name' => "".$prodnameList.""
	);
	
	$items_detailsListOdr = array_push($items_details, $item_dataorder[$key]);
	$nomneruid++;
}

//voucher code
if($res['discountamount']>0 and $res['vouchercode']<>''):
	$ongkirno = $nomneruid+1;
	$diskonamount = $res['discountamount']*-1;
	$itemdiskonprice = array(
		'id' => $ongkirno,
		'price' => $diskonamount,
		'quantity' => 1,
		'name' => "Voucher (".$res['vouchercode'].")"
	);
	
	$items_detailsListOdr = array_push($items_details, $itemdiskonprice);	
else:
	$ongkirno = $nomneruid;	
endif;


if($Shipongkir>0):
	//Ongkos Kirim
	$ongkirnoshp = $ongkirno+1;
	$itemOngkoskirim = array(
		'id' => $ongkirnoshp,
		'price' => $Shipongkir,
		'quantity' => 1,
		'name' => "Shipping Cost"
	);
	$items_detailsListOdr = array_push($items_details, $itemOngkoskirim);
endif;

$billing_address = array(
    'first_name'    => $namamenber,
    'address'       => $shipp_address_member.' - '.$namakota_member,
    'city'          => $namakabupaten_member,
    'postal_code'   => $koddepos,
    'phone'         => $member_phone,
    'country_code'  => 'IDN'
);

$shipping_address = array(
	'first_name'    => $nama_penerima,
	'last_name'     => "",
	'address'       => $shipp_address.' - '.$namakota,
	'city'          => $namakabupaten,
	'postal_code'   => $kodepos,
	'phone'         => $phone_penerima,
	'country_code'  => 'IDN'
);


// Opsional
$customer_details = array(
    'first_name'    => $namamenber,
    //'last_name'     => $lastname,
    'email'         => $emailmember,
    'phone'         => $member_phone,
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

// Fill transaction details
$transaction = array(
    'payment_type' => 'vtweb',
    'vtweb' => array(
        'credit_card_3d_secure' => true,
        ),
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $items_details,
);

$vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);



// Go to VT-Web page
header('Location: ' . $vtweb_url);
?>