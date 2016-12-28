<?php 
include("header.php"); 
@session_start();
$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING); }
if(!isset($_SESSION['token_shopcart'])){
	redirect("/".$curr_lang."/cart");
}
cek_valid_session_for_checkout($token_login);


$biaya_ongkir = 0;
$diskon_voucher = 0;
if(isset($_SESSION['ongkir'])){
	$biaya_ongkir = $_SESSION['ongkir'];
}

if(isset($_SESSION['voucher']['discount_value'])){
	$diskon_voucher = $_SESSION['voucher']['discount_value'];
}

$data_member = get_data_member_by_token_login($_SESSION['token_login']);
if($data_member['idkota'] == 0){
	redirect('/'.$curr_lang.'/edit-profile/checkout');
}


$address_book = global_select("member_addressbook","*","id_member = $data_member[id]");


if(isset($_SESSION['address_selected']) AND $_SESSION['address_selected'] != ''){
	$_SESSION['address_selected'] = $_SESSION['address_selected'];
}else{
	$_SESSION['address_selected'] = 'shipping_address';
	$cek_ongkir = global_select_single("ongkir","*","id = $data_member[idkota]");
	$ongkir = $cek_ongkir['ongkir'];
	$_SESSION['ongkir'] = $ongkir;
}

$_SESSION['berat'] = total_berat($_SESSION['token_shopcart']);
?>

	</head>
	<body class="shop-account">
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb">
							<li><span><a href="index.php" class="home"><span>Home</span></a></span></li>
							<li><span><a href="cart.php"><span>Cart</span></a></span></li>
							<li><span>Checkout</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div class="shop">
									<div class="checkout-navigation f-g6">
										<div class="cn-cart"><span>Cart</span></div>
										<div class="cn-checkout active f-g8"><span>Checkout</span></div>
										<div class="cn-done"><span>Done</span></div>
									</div><!-- .checkout-navigation -->
									<div class="row">
										<div class="col-md-5">
											<form>
												<table class="table shop_table cart">
													<thead>
														<tr>
															<th class="product-name" colspan="2" style="padding-left:15px;">Ringkasan Pembelanjaan</th>
														</tr>
													</thead>
													<tbody>
														<?php table_item_checkout($_SESSION['token_shopcart']); ?>
													</tbody>
												</table>
											</form>
											<br>
											<form>
												<table class="table shop_table cart">
													<thead>
														<tr>
															<th class="product-name" colspan="2" style="padding-left:15px;">Do You Have a Voucher?</th>
														</tr>
													</thead>
													<tbody id="voucher_list">
														<?php
														if(isset($_SESSION['voucher']['code'])){
															echo'
															<tr>
																<td class="product-name f-g8" style="padding-left:15px;">
																	'.$_SESSION['voucher']['code'].'
																</td>
																<td class="product-remove">
																	<a href="#" class="remove remove_voucher" val="'.$_SESSION['voucher']['code'].'" title="Remove this item">&times;</a>
																</td>
															</tr>';
														}
														?>
														<tr>
															<td colspan="6" class="actions">
																<div class="coupon">
																	<label for="coupon_code">Voucher:</label> 
																	<input type="text" name="voucher_code" class="input-text" id="voucher_code" value="" placeholder="Input voucher" /> 
																	<input type="button" class="button" name="apply_coupon" id="add_voucher" value="Apply Voucher"/>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</form>
										</div><!-- .col-md-5 -->
										<div class="col-md-7">
											<form action="/<?php echo $curr_lang ?>/saveorder" id="form_saveorder" method="post">
												<div class="checkout-step">
													<h2 class="f-g8">1. Courier Services</h2>
													<div class="form-flat-select">
														<select style="width:100%" name="kurir">
															<option>JNE</option>
															<option>Tiki</option>
														</select>
													</div><!-- .form-flat-select -->
												</div><!-- .checkout-step -->
												<div class="checkout-step">
													<h2 class="f-g8">2. Shipping Information</h2>
													<div class="form-group">
														<div>Shipping Note (optional)<br />
															<p class="form-control-wrap your-message">	<textarea name="shipping_note" cols="30" rows="6" class="form-control textarea"></textarea></p>
														</div>
													</div><!-- .form-group -->
													<div class="form-group">
														<div>Shipping Address<br />
															<div class="toggle toggle_default toggle_color_default checkout_toggle" id="accordion_billing">
																<div class="toggle_title">
																	<h4 class="f-g8">Use Billing Address</h4>
																	<i class="toggle_icon"></i>
																</div>
																<div class="toggle_content">
																	<div class="custom-radio">
																		<input id="custom-radio1" name="shipping_address"  class="get_ongkir" type="radio" name="pick-address" value="shipping_address" class="toggle-custom" />&nbsp;&nbsp;
																		<label for="custom-radio1">
																			<strong class="f-g8"><?php echo $data_member['fullname'] ?></strong> (<?php echo $data_member['phone'] ?>)<br>
																			<?php echo $data_member['address'] ?><br>
																			Kabupaten <?php echo $data_member['kabupaten'] ?>, Kota <?php echo get_kota_from_id($data_member['idkota'],'ongkir'); ?>, <a href="" data-rel="editBillingModal"><strong>(Edit)</strong></a>
																		</label>
																	</div><!-- .custom-radio -->
																</div>
															</div><!-- .toggle -->
															<div class="toggle toggle_default toggle_color_default checkout_toggle" id="accordion_addressbook">
																<div class="toggle_title">
																	<h4 class="f-g8">Pick from Address Book</h4>
																	<i class="toggle_icon"></i>
																</div>
																<div class="toggle_content">
																	<?php
																	if($address_book){
																		foreach ($address_book as $key => $value) {
																			echo'
																			<div class="custom-radio">
																				<input id="custom-radio2" name="shipping_address" class="get_ongkir" type="radio" name="pick-address" value="address_book#'.$value['id'].'" class="toggle-custom" />&nbsp;&nbsp;
																				<label for="custom-radio2">
																					<strong class="f-g8">'.$value['receiver_name'].'</strong> ('.$value['phone_number'].')<br>
																					'.$value['address'].'<br><a href="" data-rel="editAddressModal" id="'.$value['id'].'"><strong>(Edit)</strong></a>
																				</label>
																			</div><!-- .custom-radio -->';
																		}
																	}
																	?>
																</div>
															</div><!-- .toggle -->
														</div>
													</div><!-- .form-group -->
													<div class="form-group">
														<table class="table shop_table cart">
															<thead>
																<tr>
																	<th class="product-name" colspan="2" style="padding-left:15px;">Order Summary</th>
																</tr>
															</thead>
															<?php 
																$total_amount_cart    = total_amount_cart($_SESSION['token_shopcart']); 
																$grand_total 		= $total_amount_cart + $biaya_ongkir - $diskon_voucher;
															?>
															<tbody>
																<tr>
																	<td class="f-g8" style="padding-left:15px;">TOTAL</td>
																	<td class="f-g8" style="text-align:right;">IDR <?php echo number_format($total_amount_cart) ?></td>
																</tr>
																<?php
																if(isset($_SESSION['ongkir'])){
																	echo'
																	<tr>
																		<td class="f-g6" style="padding-left:15px;">SHIPPING FEE</td>
																		<td class="f-g6" style="text-align:right;">IDR '.number_format($_SESSION['ongkir'] * $_SESSION['berat']).'</td>
																	</tr>';
																}
																?>
																<!-- <tr>
																	<td class="f-g6" style="padding-left:15px;">HANDLING FEE</td>
																	<td class="f-g6" style="text-align:right;">IDR 20.000</td>
																</tr> -->
																<?php
																if(isset($_SESSION['voucher'])){
																	echo'
																	<tr>
																		<td class="f-g6 f-green" style="padding-left:15px;">VOUCHER<br>
																			'.$_SESSION['voucher']['code'].'
																		</td>
																		<td class="f-g6 f-green" style="text-align:right;">- IDR '.number_format($_SESSION['voucher']['discount_value']).'</td>
																	</tr>';
																}
																?>
																<tr>
																	<td class="f-g8 f-red" style="padding-left:15px;">GRAND TOTAL</td>
																	<td class="f-g8 f-red" style="text-align:right;">IDR <?php echo number_format($grand_total); ?></td>
																</tr>
															</tbody>
														</table>
													</div><!-- .form-group -->
												</div><!-- .checkout-step -->
												<div class="checkout-step">
													<h2 class="f-g8">3. Payment Method</h2>
													<div class="form-group">
														<div>
															<div class="toggle toggle_default toggle_color_default toggle_active checkout_toggle">
																<div class="toggle_title">
																	<h4 class="f-g8">Use Bank Transfer</h4>
																	<i class="toggle_icon"></i>
																</div>
																<div class="toggle_content">
																	<?php 
																	$bca = global_select_single("payment_method","*","id = 1 AND `publish` = 1"); 
																	$mandiri = global_select_single("payment_method","*","id = 2 AND `publish` = 1"); 
																	if($bca){
																		echo'
																		<div class="custom-radio">
																			<input id="custom-radio-bank1" type="radio" name="payment_method" value="'.$bca['payment'].'" class="toggle-custom toggle_payment" />&nbsp;&nbsp;
																			<label for="custom-radio-bank1">
																				<img src="/web/uploads/'.$bca['image'].'" alt="'.$bca['payment'].'" /><br>
																				'.$bca['description'].'
																			</label>
																		</div><!-- .custom-radio -->';
																	}
																	
																	if($mandiri){
																		echo'
																		<div class="custom-radio">
																			<input id="custom-radio-bank1" type="radio" name="payment_method" value="'.$mandiri['payment'].'" class="toggle-custom toggle_payment" />&nbsp;&nbsp;
																			<label for="custom-radio-bank1">
																				<img src="/web/uploads/'.$mandiri['image'].'" alt="'.$mandiri['payment'].'" /><br>
																				'.$mandiri['description'].'
																			</label>
																		</div><!-- .custom-radio -->';
																	}
																	?>
																</div>
															</div><!-- .toggle -->
															<?php 
															$cc = global_select_single("payment_method","*","id=3 AND `publish` = 1");
															if($cc){

															echo'
															<div class="toggle toggle_default toggle_color_default checkout_toggle">
																<div class="toggle_title">
																	<h4 class="f-g8">Online Payment</h4>
																	<i class="toggle_icon"></i>
																</div>
																<div class="toggle_content">
																	<div class="custom-radio">
																		<input id="custom-radio-bank3" type="radio" name="payment_method" value="'.$cc['payment'].'" class="toggle-custom toggle_payment" />&nbsp;&nbsp;
																		<label for="custom-radio-bank3">
																			<img src="/web/uploads/'.$cc['image'].'" alt="Bank Mandiri" />
																		</label>
																	</div><!-- .custom-radio -->
																</div>
															</div><!-- .toggle -->';
															}?>
														</div>
													</div><!-- .form-group -->
												</div><!-- .checkout-step -->

												<div class="custom-checkbox">
													<input id="custom-image" type="checkbox" class="toggle-custom" />&nbsp;&nbsp;
													<label for="custom-image" style="font-weight:normal;">I have read and agree with <a href="/<?php echo $curr_lang ?>/terms-and-conditions" target="_blank" class="f-g8">terms &amp; conditions</a></label>
												</div><!-- .custom-checkbox -->
											</form>
										</div><!-- .col-md-7 -->
									</div><!-- .row -->
									
									<div class="cart-collaterals">
										<div class="cart_totals">
											<div class="wc-proceed-to-checkout">
												<?php 
												if($_SESSION['valid_stok'] == 'true'){
												?>
												<a href="#" class="checkout-button button alt wc-forward" style="min-width:200px;" id="saveorder_form">PAY NOW</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("foot.php"); ?>
		</div>
		<?php include("modal.php"); ?>
		<?php include("modal_addressbook.php"); ?>
		<?php include("footer.php"); ?>

<script>
	$(document).ready(function() {
		//Bind this keypress function to all of the input tags

		$( "#saveorder_form" ).click(function(){

			var flag_payment = false;
			$(".toggle_payment").each(function(){
				if($(this).is(":checked")) {
					flag_payment = true;
				}
			});
			if(!flag_payment) {
				swal("Belum pilih payment");
				return false;
			}

			if(!$("#custom-image").is(":checked")) {
				swal("incomplete Information","please accept terms and conditions");
				return false;
			}

			//

			$( "#form_saveorder" ).submit();


		});


		<?php if(isset($_SESSION['address_selected']) AND $_SESSION['address_selected'] != ''){ ?>
			<?php if($_SESSION['address_selected'] == "shipping_address") { ?>
				$("#accordion_billing").addClass("toggle_active");
				$("#accordion_billing").find("input[value='<?php echo $_SESSION['address_selected'];?>']").prop('checked', true);
			<?php } else { ?>
				$("#accordion_addressbook").addClass("toggle_active");
				$("#accordion_addressbook").find("input[value='<?php echo $_SESSION['address_selected'];?>']").prop('checked', true);
			<?php }?>
		<?php }?>
		//alert("<?php echo $_SESSION['address_selected'] ?>");

		$("header").removeClass("header-absolute header-transparent");
	});
</script>
</body>
</html>