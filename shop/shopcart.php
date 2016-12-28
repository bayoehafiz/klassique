<?php 
@session_start();
date_default_timezone_set("Asia/Bangkok");
require('../config/nuke_library.php');
require('shopcart-table.php');

/*used Var*/
$act 		= '';
$id_product = '';
$member 	= '';
$cek 		= '';

if(isset($_SESSION['token_shopcart'])){
	$token_shopcart = filter_var($_SESSION['token_shopcart'],FILTER_SANITIZE_STRING);
}else{
	$_SESSION['token_shopcart'] = create_token();
	$token_shopcart = $_SESSION['token_shopcart'];
}

/*security input type hidden id_product*/
if($_GET['act']){$act = filter_var($_GET['act'],FILTER_SANITIZE_STRING);}


switch ($act) {
	case 'add':
		add_to_cart();
		break;

	case 'update':
		update_cart();
		break;

	case 'delete':
		delete_cart();
		break;

	case 'get_total':
		get_total_item_cart();
		break;

	case 'use_voucher':
		use_voucher();
		break;

	case 'remove_voucher':
		remove_voucher();
		break;

	case 'get_ongkir':
		get_ongkir();
		break;

	case 'cek_detail_gender':
		cek_detail_gender();
		break;

	case 'cek_detail_fit':
		cek_detail_fit();
		break;

	case 'get_id_product_detail':
		get_id_product_detail();
		break;

	case 'track_order':
		track_order();
		break;

	case 'get_stock_tersedia':
		get_stock_tersedia();
		break;

	case 'btn_add':
		btn_add();
		break;

	case 'btn_min':
		btn_min();
		break;

	default:
		die("err93y5ry5r95rty7985rty7985rty7805t80");
		break;
}

function add_to_cart(){
	global $token_shopcart;

	$sql_cek_custom1 = '';
	$sql_cek_custom2 = '';
	$sql_cek_gambar_posisi = '';

	$upload_folder 	= (isset($_POST['upload_folder']) ? $_POST['upload_folder'] : $GLOBALS['SITE_URL'].'uploads_custom_order' );
	$folder_lib_to_upload_folder = str_replace($GLOBALS['SITE_URL'], "../", $upload_folder.'/');

	if(isset($_POST['id_product'])){$id_product = filter_var($_POST['id_product'],FILTER_SANITIZE_STRING);}

	/*data member cek by token login*/
	if(isset($_SESSION['token_login'])){
		$member = get_data_member_by_token_login($_SESSION['token_login']);
		$id_member = $member['id'];
		$member_name = $member['fullname'];
	}else{
		$id_member = 0;
		$member_name = 'not_login';
	}

	/*data product yang dibeli*/
	$product = global_select_single("product","*","id = $id_product");

	/* variable untuk isi cart header */
	$cart_header['token'] 			= $token_shopcart;
	$cart_header['date_created'] 	= filter_var(date("Y-m-d h:i:s"),FILTER_SANITIZE_STRING);
	$cart_header['id_member'] 		= filter_var($id_member,FILTER_SANITIZE_STRING);
	$cart_header['status'] 			= filter_var("Waiting",FILTER_SANITIZE_STRING);
	$cart_header['date_modified'] 	= filter_var(date("Y-m-d h:i:s"),FILTER_SANITIZE_STRING);

	/*variable untuk isi cart detail*/
	$cart_detail['custom_line1']	= '';
	$cart_detail['style_line1']		= '';
	$cart_detail['custom_line2']	= '';
	$cart_detail['style_line2']		= '';
	$cart_detail['custom_gambar']	= '';
	$cart_detail['gambar_posisi']	= '';
	
	$cart_detail['token_head'] 				= $token_shopcart;
	$cart_detail['id_product'] 				= $id_product;
	$cart_detail['id_product_detail']		= filter_var($_POST['id_product_detail'],FILTER_SANITIZE_STRING);
	$cart_detail['qty'] 					= filter_var($_POST['quantity'],FILTER_SANITIZE_STRING);
	$cart_detail['product_name'] 			= filter_var($product['name'],FILTER_SANITIZE_STRING);
	$cart_detail['date_input'] 				= filter_var(date("Y-m-d h:i:s"),FILTER_SANITIZE_STRING);
	$cart_detail['is_custom'] 				= 0;
	$cart_detail['base_encode']				= NULL;

	
	/*untuk cart detail custom*/
	if(isset($_POST['check_line1']) AND $_POST['check_line1'] == 'on' AND $_POST['value_line1'] != ''){
		$cart_detail['custom_line1'] = filter_var($_POST['value_line1'],FILTER_SANITIZE_STRING);
		$cart_detail['is_custom'] 	= 1;
	}
	if(isset($_POST['check_line2']) AND $_POST['check_line2'] == 'on' AND $_POST['value_line2'] != ''){
		$cart_detail['custom_line2'] = filter_var($_POST['value_line2'],FILTER_SANITIZE_STRING);
		$cart_detail['is_custom'] 	= 1;
	}
	if(isset($_POST['check_image']) AND $_POST['check_image'] == 'on'){
		if($_FILES){
			//$rename_to_prefix = ('custom_image_'.$member_name);

			foreach ($_FILES as $key => $value) {
				
				$cart_detail['base_encode'] = encode_image($value['tmp_name']);
				$cart_detail['gambar_posisi'] 	= filter_var($_POST['image_position'],FILTER_SANITIZE_STRING);
				$sql_cek_gambar_posisi = "AND `gambar_posisi` = '".$cart_detail['gambar_posisi']."'";
				
				/*if($value['name'] != ''){
					$cart_detail['custom_gambar'] = upload_myfile($key,$folder_lib_to_upload_folder,replace_to_dash($rename_to_prefix));
					$cart_detail['base_encode'] = encode_image('../uploads_custom_order/'.$cart_detail['custom_gambar']);
					$cart_detail['gambar_posisi'] 	= filter_var($_POST['image_position'],FILTER_SANITIZE_STRING);
					$sql_cek_gambar_posisi = "AND `gambar_posisi` = '".$cart_detail['gambar_posisi']."'";
				}*/
			}
		}
		$cart_detail['is_custom'] 		= 1;
	}

	$sql_cek_custom1 = "AND `custom_line1` = '$cart_detail[custom_line1]'";
	$sql_cek_custom2 = "AND `custom_line2` = '$cart_detail[custom_line2]'";

	$status = "fresh"; # Status fresh

	/*Validasi valid id product bila product id di otak atik dari inspect*/
	$cek_id_product_in_database = global_select_single("product","id","id = $id_product");
	if(!$cek_id_product_in_database){
		$status = "cheat_inspect";
	};

	/*validasi quantity*/
	if($cart_detail['qty'] <= 0){
		$status = "quantity_error";
	}else{
		$cek_db = global_select_single("product_detail_size","*","id = $cart_detail[id_product_detail]");
		if( $cart_detail['qty'] > $cek_db['stock']){
			$status = "quantity_error";
		}
	}


	$cart_detail['style_line1'] = 'Plain';
	$cart_detail['style_line2'] = 'Plain';
	if(isset($_POST['style_line1'])){
		$cart_detail['style_line1'] = filter_var($_POST['style_line1'],FILTER_SANITIZE_STRING);
	}
	if(isset($_POST['style_line2'])){
		$cart_detail['style_line2'] = filter_var($_POST['style_line2'],FILTER_SANITIZE_STRING);
	}

	/*Jalankan Proses hanya jika status masih fresh*/
	if($status == 'fresh'){
		/*cek Token shopcart sudah ada belum. kalo udah ada. dia update ke cart detail*/
		$cek = global_select_single("shopcart_header","id","token = '$cart_header[token]'");
		if($cek['id']){
			if($cart_detail['is_custom'] == 1){
				/*cek udah ada apa belom id product nya. dan custom bordirnya*/
				$cek_shopcart_detail 	= global_select_single("shopcart_detail","*","`token_head` = '$cart_header[token]' AND `id_product_detail` = $cart_detail[id_product_detail] AND `base_encode` = '$cart_detail[base_encode]' AND `is_custom` = 1 $sql_cek_custom1 $sql_cek_custom2 $sql_cek_gambar_posisi",false,false,false);
				$id_record_for_update	= $cek_shopcart_detail['id'];
			}else{
				/*cek udah ada apa belom id product nya*/
				$cek_shopcart_detail 	= global_select_single("shopcart_detail","*","`token_head` = '$cart_header[token]' AND `id_product_detail` = $cart_detail[id_product_detail] AND `is_custom` = 0");
				$id_record_for_update	= $cek_shopcart_detail['id'];
			}

			if(isset($id_record_for_update)){
				$new_qty 			= $cek_shopcart_detail['qty'] + $cart_detail['qty']; 
				if( $new_qty > $cek_db['stock']){
					$new_qty = $cek_db['stock'];
				}

				$cek_stok_from_shopcart_detail = global_select_single("shopcart_detail","SUM(`qty`) AS `qty` ","token_head = '$token_shopcart' AND `id_product_detail` = $cart_detail[id_product_detail]",false,false,false);
				$qty_shopcart = ($cek_stok_from_shopcart_detail['qty']*1);

				if($qty_shopcart >= $cek_db['stock']){
					
					$status = "quantity_error";
				}else{				
					$total_kesleuruhan = ($qty_shopcart*1) + ($cart_detail['qty']*1);
					$total_stok = ($cek_db['stock']*1);
					$update_quantity 	= global_update("shopcart_detail",array('qty' => $new_qty),"`id` = '$id_record_for_update'");
					$status 			= "update_quantity_sukses";
				}
			}else{

				$cek_stok_from_shopcart_detail = global_select_single("shopcart_detail","SUM(`qty`) AS `qty` ","token_head = '$token_shopcart' AND `id_product_detail` = $cart_detail[id_product_detail]");
				$qty_shopcart = $cek_stok_from_shopcart_detail['qty'];
				if($qty_shopcart >= $cek_db['stock']){
					$status = "quantity_error";
				}else{
					
					$total_kesleuruhan = ($qty_shopcart*1) + ($cart_detail['qty']*1);
					$total_stok = ($cek_db['stock']*1);
					if($total_kesleuruhan > $total_stok){
						$status = "quantity_error";							
					}else{
						$update_cart_detail = global_insert("shopcart_detail",$cart_detail);
						$status 			= "tambah_record_sukses";
					}
				}
			}
		}else{
			$insert_cart_header 	= global_insert("shopcart_header",$cart_header);
			$insert_cart_detail 	= global_insert("shopcart_detail",$cart_detail);
			$status 				= "add_header_baru_sukses";
		}
	}

	/*Add to cart . Done Handler*/
	if($status == "update_quantity_sukses"){
		echo 'Item Quantity updated#'.$cart_detail['product_name'].' has been Updated at shopping cart#success';
	}elseif ($status == "tambah_record_sukses") {
		echo 'Item Added#'.$cart_detail['product_name'].' has been added to your shopping cart#success';
	}elseif ($status == "add_header_baru_sukses") {
		echo 'Item Added#'.$cart_detail['product_name'].' has been added to your shopping cart#success';
	}elseif ($status == "quantity_error") {
		echo 'Item quantity not available #'.$cart_detail['product_name'].' has been added to your shopping cart#warning';
	}else{
		echo 'Item Not Added#'.$cart_detail['product_name'].' Cannot added to cart!, please check your product#error';
	}
}

function update_cart(){
	global $token_shopcart;
	$new_qty 	= $_POST['new_qty'];
	$record_id 	= $_POST['item_id'];

	$cek = global_select_single("shopcart_detail","id_product_detail","id = $record_id");
	$id_product_detail = $cek['id_product_detail'];
	$cek_stok_now = global_select_single("product_detail_size","*","id = $id_product_detail");
	$stok_tersedia = ($cek_stok_now['stock']*1);

	if($new_qty >= 1){

		$cek_stok_from_shopcart_detail = global_select_single("shopcart_detail","SUM(`qty`) AS `qty` ","token_head = '$token_shopcart' AND `id_product_detail` = $id_product_detail",false,false,false);
		$qty_shopcart = ($cek_stok_from_shopcart_detail['qty']*1);

		if($qty_shopcart > $stok_tersedia){
			global_update("shopcart_detail",array('qty' => $stok_tersedia),"`id` = '$record_id'");
			echo "failed#limited stock";
			return false;
		}

		if($new_qty > $stok_tersedia){
			$new_qty = $stok_tersedia;
			echo "failed#limited stock";
			return false;
		}
		$update_quantity 	= global_update("shopcart_detail",array('qty' => $new_qty),"`id` = '$record_id'");
		echo "sucess#quantity updated";
	}else{
		$update_quantity 	= global_delete("shopcart_detail","`id` = '$record_id'");
		echo "sucess#item deleted";
	}
}

function delete_cart(){
	global $token_shopcart;

	$record_id 	= $_POST['item_id']; 

	/*cek id record ini punya dia bukan*/
	$cek = global_select_single("shopcart_detail","*","token_head = '$token_shopcart' AND `id` = $record_id");

	if($cek){

		/*if(file_exists('../uploads/'.$cek['custom_gambar'])){
			chown("../uploads".$cek['custom_gambar'],666); 
			unlink('../uploads/'.$cek['custom_gambar']);
		}*/

		$delete 	= global_delete("shopcart_detail","id = $record_id");
		$cek_jumlah = num_rows("shopcart_detail","*","token_head = '$token_shopcart'");
		if($cek_jumlah == 0){
			echo 2;
		}else{
			echo 1;
		}
	}else{
		echo 0;
	}
}

function get_total_item_cart(){
	global $token_shopcart;
	if(isset($token_shopcart)){
		echo total_item($token_shopcart);
	}else { 
		echo 'no! '; 
		exit; 
	}
}

function use_voucher(){
	global $token_shopcart;
	global $db;


	if(isset($_POST['code'])){
		$code = filter_var($_POST['code'],FILTER_SANITIZE_STRING);
	}

	$member = get_data_member_by_token_login($_SESSION['token_login']);
	$num_rows = num_rows("order_header","*","vouchercode = '$code' AND `idmember` = $member[id]");
	
	if($num_rows == 0){
		$voucher = global_select_single("voucher","*","`code` = '$code' AND `max_used` > 0");
		
		if($voucher){

			if(isset($_SESSION['voucher_code'])){
				echo 2;
				die();
			}

			$total_amount_cart    			= total_amount_cart($_SESSION['token_shopcart']);
			$discount_voucher 				= $voucher['value'];
			$min_amount_to_get_discount 	= $voucher['min_shop'];
			$max_used					 	= $voucher['max_used'];
			$expired					 	= strtotime($voucher['expired_date']);
			$date_now 						= strtotime(date("Y-m-d"));

			if($total_amount_cart > $min_amount_to_get_discount && $max_used > 0 AND ($expired > $date_now)){
				$_SESSION['voucher']['code'] = $code;
				$_SESSION['voucher']['discount_value'] = $voucher['value'];
				echo 1;
			}
		}else{
			echo 0;
		}
	}else{
		echo 3;
	}
}

function remove_voucher(){
	global $token_shopcart;

	unset($_SESSION['voucher']);
	echo 1;
}

function get_ongkir(){
	global $token_shopcart;

	if($_POST['type'] == 'shipping_address'){
		$member = get_data_member_by_token_login($_SESSION['token_login']);
		$idkota = $member['idkota'];
		if($idkota){
			$cek_ongkir = global_select_single("ongkir","*","id = $idkota");
			$ongkir = $cek_ongkir['ongkir'];
			$_SESSION['ongkir'] = $ongkir;
			$_SESSION['address_selected'] = $_POST['type'];
			echo 1;
		}
	}else{
		$get_id_address = explode("#",$_POST['type']);
		$id_address = $get_id_address[1];

		$cek_addressbook = global_select_single("member_addressbook","*","id = $id_address");

		$idkota_ongkir = $cek_addressbook['idkota'];

		$cek_ongkir = global_select_single("ongkir","*","id = $idkota_ongkir");
		$ongkir = $cek_ongkir['ongkir'];
		$_SESSION['ongkir'] = $ongkir;
		$_SESSION['address_selected'] = $_POST['type'];
		echo 1;
	}
}

function cek_detail_gender(){
	global $token_shopcart;

	$id_product = $_POST['id_product'];
	$id_master_gender = $_POST['gender'];
	$cek_type = global_select("product_detail_size","*","id_product = $id_product AND gender = $id_master_gender GROUP BY `fit_type`","");
	if($cek_type){
		
		/*query master Fit Type*/
		echo '<option>- Please Select -</option>';
		if($cek_type){
			foreach ($cek_type as $key_t => $value_t) {
				echo'<option value="'.$value_t['fit_type'].'">'.get_fit_from_id($value_t['fit_type'],"product_type").'</option>';
			}
		}
	}
}

function cek_detail_fit(){
	global $token_shopcart;

	$id_product 		= $_POST['id_product'];
	$id_master_gender 	= $_POST['gender'];
	$fit_type 			= $_POST['fit_type'];
	$curr_lang			= $_POST['curr_lang'];
	$display_lang_size	= $_POST['display_lang_size'];
	$cek_size = global_select("product_detail_size","*","id_product = $id_product AND gender = $id_master_gender AND `fit_type` = $fit_type GROUP BY `size`","");
	if($cek_size){
		
		/*query master Fit Type*/
		if($cek_size){
			$i = 1;
			echo '
			<td><label>'.$display_lang_size.'</label></td>
			<td>';
			foreach ($cek_size as $key_s => $value_s) {
				
				if($value_s['stock'] != 0){
					/*if($i == 1){
						$selected = "selected";
					}else{
						$selected = '';
					}*/
					echo'
					<div class="'.$selected.' select-option swatch-wrapper size_select_'.$value_s['id'].'" id="'.$value_s['id'].'">
						<a href="#" title="Extra Large" id='.($value_s['id']).' class="swatch-anchor get_size">
							<img src="/images/sizes/'.get_size_from_id($value_s['size'],"product_size").'.jpg" alt="thumbnail" width="35" height="35"/>
						</a>
					</div>
					';	
					$i++;
				}
			}
			echo'</td>';
			echo"
			<script>
				$(document).ready(function() {
					$('.get_size').click(function(e) { 
						var size = $(this).attr('id');
						$('.swatch-wrapper').removeClass('selected');
						$('.size_select_'+size).addClass('selected');
						$('#ukuran_size').val(size);
						e.preventDefault();
					});
				});
			</script>
			";
		}
	}
}

function get_id_product_detail(){

	$id_product 		= filter_var($_POST['id_product'],FILTER_SANITIZE_STRING);
	$fit_type 			= filter_var($_POST['fit_type'],FILTER_SANITIZE_STRING);
	$id_master_gender 	= filter_var($_POST['gender'],FILTER_SANITIZE_STRING);

	$cek_size = global_select_single("product_detail_size","*","id_product = $id_product AND gender = $id_master_gender AND `fit_type` = $fit_type GROUP BY `size`","");
	echo $cek_size['id'];
}

function track_order(){
	$idorder = filter_var($_POST['orderid'],FILTER_SANITIZE_NUMBER_INT);
	$a = global_select_single("order_header","*","id = $idorder");
	if($a){
		echo "Your Order Status : <strong>".$a['status_payment'].'</strong> | Your Delivery Status : <strong>'.$a['status_delivery'].'</strong>';
	}else{
		echo "Not Found";
	}
}

function get_stock_tersedia(){
	$id_product_detail = filter_var($_POST['id_product_detail'],FILTER_SANITIZE_STRING);
	$id_product_detail = str_replace(array('\n', '\r'), '', $id_product_detail);
	
	$stok = global_select_single("product_detail_size","*","id = $id_product_detail");
	echo $stok['stock'];
}

function btn_add(){
	global $token_shopcart;
	$new_qty 	= $_POST['new_qty'];
	$record_id 	= $_POST['item_id'];

	$cek = global_select_single("shopcart_detail","id_product_detail","id = $record_id");
	$id_product_detail = $cek['id_product_detail'];
	$cek_stok_now = global_select_single("product_detail_size","*","id = $id_product_detail");
	$stok_tersedia = ($cek_stok_now['stock']*1);

	if($new_qty >= 1){

		$cek_stok_from_shopcart_detail = global_select_single("shopcart_detail","SUM(`qty`) AS `qty` ","token_head = '$token_shopcart' AND `id_product_detail` = $id_product_detail",false,false,false);
		$qty_shopcart = ($cek_stok_from_shopcart_detail['qty']*1);

		if($qty_shopcart > $stok_tersedia){
			echo "failed#limited stock";
			return false;
		}

		$update_quantity = $qty_shopcart+1;
		if($update_quantity > $stok_tersedia){
			$new_qty = $stok_tersedia;
			echo "failed#limited stock";
			return false;
		}
		$update_quantity 	= global_update("shopcart_detail",array('qty' => $new_qty),"`id` = '$record_id'");
		echo "sucess#quantity updated";
	}else{
		$update_quantity 	= global_delete("shopcart_detail","`id` = '$record_id'");
		echo "sucess#item deleted";
	}
}

function btn_min(){
	global $token_shopcart;
	$new_qty 	= $_POST['new_qty'];
	$record_id 	= $_POST['item_id'];

	$cek = global_select_single("shopcart_detail","id_product_detail","id = $record_id");
	$id_product_detail = $cek['id_product_detail'];
	$cek_stok_now = global_select_single("product_detail_size","*","id = $id_product_detail");
	$stok_tersedia = ($cek_stok_now['stock']*1);

	if($new_qty >= 1){

		$cek_stok_from_shopcart_detail = global_select_single("shopcart_detail","SUM(`qty`) AS `qty` ","token_head = '$token_shopcart' AND `id_product_detail` = $id_product_detail",false,false,false);
		$qty_shopcart = ($cek_stok_from_shopcart_detail['qty']*1);

		$update_quantity = $qty_shopcart-1;
		if($update_quantity > $stok_tersedia){
			$new_qty = $stok_tersedia;
		}

		$update_quantity 	= global_update("shopcart_detail",array('qty' => $update_quantity),"`id` = '$record_id'");
		echo "sucess#quantity updated";
	}else{
		$update_quantity 	= global_delete("shopcart_detail","`id` = '$record_id'");
		echo "sucess#item deleted";
	}
}
?>