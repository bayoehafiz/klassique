
<?php 
@session_start();
//--- VER 0.1 --- AUG 2015 -- 
//Shopping cart CORE ENGINE -- NGC 28082015 
//LAST UPDATE 16/10/2015 - 09:44:00 - HH
//NOTE: So far masih ada HTML yang masuk ke function, 
//      nanti kedepannya akan dibuat pure hanya logic saja
//      tidak ada html yang diembed di core function ini.

//----- 

function total_item($token){
	
	$total_arr   = global_select_single('shopcart_detail','SUM(qty) as qty',"`token_head` = '$token'");    
	$total_item  = 0;
	
	if($total_arr['qty'] > 0 ) {
		
		$total_item =  $total_arr['qty'];

	}else { $total_item = 0; }
	
		return $total_item;
}

function update_shopcart_status($token,$idmember){
	
	$arr_update = array("status" => "finished", "idmember" =>$idmember);
	$update  = global_update('shopcart_header',$arr_update,"`token` = '$token'");

}

function flush_shopcart($token){
	
	$update  = global_delete('shopcart_detail',"`token_head` = '$token'");
	
}


function total_berat($token){
	
	$berat = global_select('shopcart_detail,product','shopcart_detail.qty, product.weight, product.dimension',"shopcart_detail.id_product = product.id AND `token_head` = '$token'");
	$total_weight   = '';
	$total_volume   = '';
	$weight_final   = 1;
	
	if($berat){

		foreach($berat as $key => $value){

			//debug mode
			//echo 'qty: '. ($value['qty'] .' *  berat: '. $value['weight']).'= '. $value['qty']*$value['weight'].'<br>';
			
			//weight
			$total_weight   = $total_weight + ($value['qty'] * $value['weight']);
			if($value['dimension'] != 0){
				$dim_each       = explode('x',$value['dimension']);
				//--
				
				//volume
				$volume_each    = $dim_each[0] * $dim_each[1] * $dim_each[2];
				$total_volume   = $total_volume + ($volume_each * $value['qty']);
			}
			//debug..
			//echo 'vc: '.$volume_each.' * qty: '.$value['qty'].' = '.$volume_each * $value['qty'].'<br/>';
			//echo $total_volume;
			//--
			
		}
			//convert from gram to kg
			$total_weight = $total_weight / 1000;
		
			//ubah dari milimetercubic ke cm kubic
			$total_volume   = $total_volume/100;
		
			//pembagian menurut si JNE -- convert dari volume ke berat..
			$total_volume   = round($total_volume / 6000); 
			
			//timbang antara berat dan volume
			
			if($total_volume > $total_weight){
				$weight_final = $total_volume;
			}
			if($total_volume < $total_weight){
				$weight_final = $total_weight;
			}

			/*echo 'total vol : '.$total_volume .'<br />';
			echo 'total weight : '.$total_weight. '<br />';
			echo $weight_final;*/
		
		
	}else { echo 'something wrong!'; }
	
	return $weight_final;	
}



function table_item($token,$curr_lang){
	
	$table      = global_select('shopcart_detail','*',"`token_head` = '$token'",'id ASC');
	$sale_price = 0;
	$grandtotal = 0;
	$item_tampung = '';
	$custom_gambar = '';
	$qty_tampunt = 0;
	$other_fee  = 0;
	$addon_price1 = 0;
	$addon_price2 = 0;
	$addon_price_gambar = 0;
	$view_custom_price = '';
	$custom_line1 = '';
	$custom_line2 = '';
	$custom_image = 'No';


	if($table){
		echo'
		<form>
		<table class="table shop_table cart">
		<thead>
			<tr>
				<th class="product-remove hidden-xs">&nbsp;</th>
				<th class="product-thumbnail hidden-xs">&nbsp;</th>
				<th class="product-name">Product</th>
				<th class="product-price text-center" style="text-align:right;">Price</th>
				<th class="product-quantity text-center">Quantity</th>
				<th class="product-subtotal text-center hidden-xs" style="text-align:right;">Total</th>
			</tr>
		</thead>
		<tbody>
		';

		foreach($table as $key=>$value){
			


			$id_product   			= $value['id_product'];
			$id_product_detail   	= $value['id_product_detail'];
			$id_shopcart_record 	= $value['id'];
			$custom_gambar 			= 'none';
			$gambar_posisi 			= 'none';
			$custom_line1 			= 'none';
			$custom_line2 			= 'none';
			$sale_price				= 0;
			$addon_price1			= 0;
			$addon_price2			= 0;
			$addon_price_gambar		= 0;
			//fetch prod detail data..
			$product = global_select_single('product','*',"`id` = $id_product");
			
			//cek diskon... 
			if(isset($product['discount_percent']) AND $product['discount_percent'] > 0 AND $product['sale_status'] == 1) { 
				$diskon = $product['discount_percent'];
				$sale_price = $product['price_normal'] - ( $product['price_normal'] * $diskon / 100 );

			 }else { $diskon = 0; $sale_price = $product['price_normal']; }
			 //---- 
			
			/*variable custom orderan*/
			if(isset($value['custom_line1']) AND $value['custom_line1'] != ''){
				$custom_line1 = $value['custom_line1'].' ('.$value['style_line1'].')';
				$addon_price1 = $product['price_custom_line1'];
			}
			if(isset($value['custom_line2']) AND $value['custom_line2'] != ''){

				$custom_line2 = $value['custom_line2'].' ('.$value['style_line2'].')';
				$addon_price2 = $product['price_custom_line2'];
			}
			if(isset($value['base_encode']) AND $value['base_encode'] != ''){
				$custom_gambar = '<img width="100" height="100" src="'.$value['base_encode'].'">';
				$addon_price_gambar = $product['price_custom_gambar'];
			}
			$gambar_posisi = "None";
			if(isset($value['gambar_posisi']) AND $value['gambar_posisi'] != ''){
				$gambar_posisi = $value['gambar_posisi'];
			}
			//itung total
			$harga_satuan = $sale_price + $addon_price1+$addon_price2+$addon_price_gambar;
			$total  = $value['qty'] * ($sale_price+$addon_price1+$addon_price2+$addon_price_gambar);
			$view_custom_price = '+ '.$addon_price1+$addon_price2+$addon_price_gambar;
			
			$get_data_detail = global_select_single("product_detail_size","*","id = $id_product_detail");

			$quantity = $value['qty'];
			$quantity_database = $get_data_detail['stock'];

			if($quantity > $quantity_database){
				$quantity = $quantity_database;
			}

			$gender = get_gender_from_id($get_data_detail['gender'],'product_gender');
			$size 	= get_size_from_id($get_data_detail['size'],'product_size');
			$fit_type = get_fit_from_id($get_data_detail['fit_type'],'product_type');


			//fetch and print table ---
			 echo   '
			 <tr class="cart_item" id="record_'.$id_shopcart_record.'">
				<td class="product-remove hidden-xs">
					<a href="#" class="remove remove_form_cart" id="'.$id_shopcart_record.'" title="Remove this item">&times;</a>
				</td>
				<td class="product-thumbnail hidden-xs">
					<a href="#">
						<img width="100" height="150" src="/images/klassique/product/thumb1.png" alt="Product-1"/>
					</a>
				</td>
				<td class="product-name">
					<a href="#">'.$value['product_name'].'</a>
					<dl class="variation">
						<dt class="variation-Color">Gender:</dt><dd class="variation-Color"><p>'.$gender.'</p></dd>
						<dt class="variation-Size">Size:</dt><dd class="variation-Size"><p>'.$size.'</p></dd>
						<dt class="variation-Fit">Fit:</dt><dd class="variation-Fit"><p>'.$fit_type.'</p></dd>';

						if($value['is_custom'] == 1){
							echo'
							<dt class="variation-CustomText">Custom Text Line 1:</dt><dd class="variation-CustomText"><p>'.$custom_line1.'</p></dd>
							<dt class="variation-CustomText">Custom Text Line 2:</dt><dd class="variation-CustomText"><p>'.$custom_line2.'</p></dd>';
							
							if($value['base_encode'] != ''){
								echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p><img width="100" height="100" src="'.$value['base_encode'].'"></p></dd>';
							}else{
								echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p>None</p></dd>';
							}
							echo'<dt class="variation-CustomText">Position Image:</dt><dd class="variation-CustomText"><p>'.$gambar_posisi.'</p></dd>';
						}
						echo'
					</dl>
				</td>
				<td class="product-price text-center" style="text-align:right;">
					<span class="amount">IDR '.number_format($harga_satuan).'</span>
				</td>
				<td class="product-quantity text-center">
					<div class="quantity" style="float:left">
						<input type="text" id="quantity_product-'.$id_shopcart_record.'" record="'.$id_shopcart_record.'" step="1" min="0" name="quantity" value="'.$quantity.'" title="Qty" class="input-text qty text quantity_number" size="4" style="margin:0 auto;" />
					</div>
					<div style="float:left;margin-left:10px;">
					<a href="javascript:void();" class="btn-add" id="'.$id_shopcart_record.'" value="'.$quantity.'" style="border:1px solid #ccc;line-height:1.0em; display:inline-block;text-decoration:none; padding:2px 3px 3px 3px;margin-bottom:5px;">+</a><br/>
					<a href="javascript:void();" class="btn-min" id="'.$id_shopcart_record.'" value="'.$quantity.'" style="border:1px solid #ccc;line-height:1.0em; display:inline-block;text-decoration:none; padding:2px 4px 3px 4px;">-</a></div>
					<div style="clear:both"></div>
				</td>
				<td class="product-subtotal hidden-xs text-center" style="text-align:right;">
					<span class="amount">IDR '.number_format($total).'</span>
				</td>
			</tr>';
			
			$grandtotal = $grandtotal + $total;
			//--- 

			}
			 
			echo'
				<tr>
					<td colspan="6" class="actions f-g8 cart-gtotal">
						GRAND TOTAL<span>IDR '.number_format($grandtotal).'</span>
					</td>
				</tr>
			</tbody>
				</table>
			</form>
			<div class="cart-collaterals">
				<div class="cart_totals">
					<div class="wc-proceed-to-checkout">';
						if(isset($_SESSION['token_login'])){
							echo '<a href="/'.$curr_lang.'/checkout" class="checkout-button button alt wc-forward">Proceed to Checkout</a>';
						}else{
							?><a href="#" data-rel="loginModal_checkout" class="checkout-button button alt wc-forward">Proceed to Checkout</a><?php
						}
						echo'
					</div>
				</div>
			</div>';
			
			//UPDATED BY KAU 08/10/2015 SET to ZERO BY HH SET TAX to ZERO 
		
			//Default set;
			//$tax    = $grandtotal * 10/100; 
			$tax      = 0;
				
			  // echo  '<div class="scb-total clearfix">
					// 	<div class="scbt-lr">
					// 		<div class="scbt-left">
					// 			Total<br />
					// 			<span class="greener">GRAND TOTAL</span>
					// 		</div><!-- .scbt-left -->
					// 		<div class="scbt-right">
					// 			Rp '.number_format($grandtotal).'<br />
					// 			<span class="greener">Rp '.number_format($grandtotal + $tax).'</span>
					// 		</div><!-- .scbt-right -->
					// 	</div><!-- .scbt-lr -->
					//  </div><!-- .scb-total -->';
			
			
			//--- end of update
		
		   
		
		
	}else { echo '<span>There is no item in your shopping cart</span>'; }
	
}

function table_item_thankyou($token){
	
	$arr_config = global_select_single('web_config','*');
	$table      = global_select('shopcart_detail','*',"`token_head` = '$token'",'id ASC');
	$other_fee  = global_select_single('order_header','ongkir,handling_fee',"`token` = '$token'");
	
	$sale_price = 0;
	$grandtotal = 0;
	$tax    = 0;
	
	echo '<div class="sc-top clearfix">              
				<div class="sct1">
					<div class="sct1-cwrap">
						<div class="sct123 clearfix">
							<span class="sct1-1">
								<span class="sct11-1">
									<span class="f-rb">Product</span>
								</span><!-- .sct11-1 -->
								<span class="sct11-2">
									<span class="f-rb">Price</span>
								</span><!-- .sct11-2 -->
							</span><!-- .sct1-1 -->
							<span class="sct1-23">
								<span class="sct1-2 f-rb">Qty</span>
								<span class="sct1-3 f-rb">Sub Total</span>
							</span><!-- .sct1-23 -->
						</div><!-- .sct123 -->
					</div><!-- .sct1-cwrap -->
				</div><!-- .sct1 -->
			</div><!-- .sc-top -->';
	
	if($table){
		
		foreach($table as $key=>$value){
			
			 $idprod   = $value['idprod'];
			 
			 //fetch prod detail data..
			 $prod_det = global_select_single('product','*',"`id` = $idprod");
				

			 //cek diskon... 
			 if($prod_det['discount_persen'] > 0 ) { 
				$diskon = $prod_det['discount_persen'];
				$sale_price = $prod_det['normal_price'] - ( $prod_det['normal_price'] * $diskon / 100 );

			 }else { $diskon = 0; $sale_price = $prod_det['normal_price']; }
			 //---- 
			
			//itung total
			$total  = $value['qty'] * $sale_price;
			
			//fetch and print table --- 
			 
			echo '<div class="scb-child clearfix">
					<div class="scbc scb1 clearfix">
						<div class="img-wrap"><a href="/product-detail/'.$prod_det['urlpage'].'">
						<img src="/web/'.$prod_det['image'].'" /></a></div>
						<div class="scb1-txt clearfix">
							<div class="scb1-1">
								<div class="scb11-1">
									<h3 class="f-rb"><a href="/product-detail/'.$prod_det['urlpage'].'">'.$prod_det['name'].'</a></h3>
								</div><!-- .scb11-1 .-->
								<div class="scb11-2">
									<p>Rp '.number_format($sale_price).'</p>
								</div><!-- .scb11-2 -->
							</div><!-- .scb1-1 -->
							<div class="scb23">
								<div class="scb1-2">
									'.$value['qty'].'
								</div><!-- .scb1-2 -->
								<div class="scb1-3">
									<strong><span>Total </span>Rp '.number_format($total).'</strong>
								</div><!-- .scb1-3 -->
							</div><!-- .scb23 -->
						</div><!-- .scb1-txt -->
					</div><!-- .scbc -->
				</div><!-- .scb-child -->';
			
			 $grandtotal = $grandtotal + $total;
			}
		
			//UPDATED BY KAU 08/10/2015 SET to ZERO BY HH SET TAX to ZERO and EXCLUDE handling Fee 
			//untuk shipping Jabodetabek di luar itu ada tax dan handling fee lalu dikurangin 50.000
		
			//Default set;
			//$tax    = $grandtotal * 10/100; 
			//$other_fee = $other_fee['ongkir'] + $other_fee['handling_fee'];
		
			//UPDATE 29/10/2015 -- REMOVE TAX BY HH 
			
			if($other_fee['ongkir'] == 0 ){
			
				$tax        = 0; 
				$other_fee  = $other_fee['ongkir'];
				
				echo '<div class="scb-total clearfix">
					<div class="scbt-lr">
						<div class="scbt-left">
							Total<br>
							Shipping + Handling <br />
							<span class="greener">GRAND TOTAL</span>
						</div><!-- .scbt-left -->
						<div class="scbt-right">
							Rp '.number_format($grandtotal).'<br />
							FREE <br />
							<span class="greener">Rp '.number_format($grandtotal + $other_fee).'</span>
						</div><!-- .scbt-right -->
					</div><!-- .scbt-lr -->
				</div><!-- .scb-total -->';
			
			}else { 
				$subsidy_fee    = $arr_config['subsidy_fee'];
				$tax            = $grandtotal * 10/100; //atau tarik dari web_config
				$other_fee      = ($other_fee['ongkir'] + $other_fee['handling_fee']); 
				
				//UPDATE 29/10/2015 -- REMOVE TAX BY HH
				
				 echo '<div class="scb-total clearfix">
					<div class="scbt-lr">
						<div class="scbt-left">
							Total<br>
							Shipping + Handling <br />
							Subsidy from Karsamudika <br />
							<span class="greener">GRAND TOTAL</span>
						</div><!-- .scbt-left -->
						<div class="scbt-right">
							Rp '.number_format($grandtotal).'<br />
							Rp '.number_format($other_fee).'<br />
							<span style="color:red">(Rp '.number_format($subsidy_fee).')</span> <br/>
							<span class="greener">Rp '.number_format($grandtotal + $other_fee - $subsidy_fee).'</span>
						</div><!-- .scbt-right -->
					</div><!-- .scbt-lr -->
				</div><!-- .scb-total -->';
			
			}
			//--- end of update
		
		   
		   
		
	}else { echo '<span><br />There is no item in your shopping cart</span>'; }
	
}

function table_item_checkout($token){
	
	$table      			= global_select('shopcart_detail','*',"`token_head` = '$token'",'id ASC');
	

	if($table){
		
		$value_jumlah = 0;
		foreach($table as $key=>$value){
			$sale_price				= 0;
			$addon_price1			= 0;
			$addon_price2			= 0;
			$addon_price_gambar		= 0;
			$total					= 0;
			$stat_custom 			= '';
			$custom_line1 			= 'No';
			$custom_line2 			= 'No';
			$custom_gambar 			= 'No';


			$_SESSION['valid_stok'] = 'true';
			$id_product   = $value['id_product'];
			$id_product_detail   = $value['id_product_detail'];
			$id_shopcart_record = $value['id'];
			//fetch prod detail data..
			$product = global_select_single('product','*',"`id` = $id_product");

			//cek diskon... 
			if(isset($product['discount_percent']) AND $product['discount_percent'] > 0 AND $product['sale_status'] == 1) { 
				$diskon = $product['discount_percent'];
				$sale_price = $product['price_normal'] - ( $product['price_normal'] * $diskon / 100 );

			 }else { $diskon = 0; $sale_price = $product['price_normal']; }
			 //---- 
			
			/*variable custom orderan*/
			if(isset($value['custom_line1']) AND $value['custom_line1'] != ''){
				$custom_line1 = $value['custom_line1'].' ('.$value['style_line1'].')';
				$addon_price1 = $product['price_custom_line1'];
			}
			if(isset($value['custom_line2']) AND $value['custom_line2'] != ''){
				$custom_line2 = $value['custom_line2'].' ('.$value['style_line2'].')';
				$addon_price2 = $product['price_custom_line2'];
			}
			if(isset($value['base_encode']) AND $value['base_encode'] != ''){
				$custom_gambar = '<img width="100" height="100" src="'.$value['base_encode'].'">';
				$addon_price_gambar = $product['price_custom_gambar'];
			}

			//itung total
			$harga_jual_satuan = $sale_price+$addon_price1+$addon_price2+$addon_price_gambar;
			$total  = $value['qty'] * ($sale_price+$addon_price1+$addon_price2+$addon_price_gambar);
			$view_custom_price = '+ '.$addon_price1+$addon_price2+$addon_price_gambar;
			
			$get_data_detail = global_select_single("product_detail_size","*","id = $id_product_detail");

			$gender = get_gender_from_id($get_data_detail['gender'],'product_gender');
			$size 	= get_size_from_id($get_data_detail['size'],'product_size');
			$fit_type = get_fit_from_id($get_data_detail['fit_type'],'product_type');

			//fetch and print table ---
			 echo  '
				<tr>
					<td class="product-thumbnail">
						<a href="#">
							<img width="100" height="150" src="/web/uploads/'.$product['product_image'].'" alt="Product-1"/>
						</a>
					</td>
					<td class="product-name">
						<a href="#">'.$product['name'].'</a>
						<dl class="variation">
							<dt class="variation-Color">Harga:</dt><dd class="variation-Color"><p>Rp '.number_format($harga_jual_satuan).'</p></dd>
							<dt class="variation-Color">Gender:</dt><dd class="variation-Color"><p>'.$gender.'</p></dd>
							<dt class="variation-Size">Qty:</dt><dd class="variation-Size"><p>'.$value['qty'].'</p></dd>
							<dt class="variation-Size">Size:</dt><dd class="variation-Size"><p>'.$size.'</p></dd>
							<dt class="variation-Size">Fit:</dt><dd class="variation-Size"><p>'.$fit_type.'</p></dd>';
							if($value['is_custom'] == 1){
								echo'
								<dt class="variation-CustomText">Custom Text Line 1:</dt><dd class="variation-CustomText"><p>'.$custom_line1.'</p></dd>
								<dt class="variation-CustomText">Custom Text Line 2:</dt><dd class="variation-CustomText"><p>'.$custom_line2.'</p></dd>';
								if($value['base_encode'] != ''){
									echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p><img width="100" height="100" src="'.$value['base_encode'].'"></p></dd>';
								}else{
									echo'<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p>None</p></dd>';
								}
							
							}
							echo'
							<dt class="variation-Fit">Total Rp '.number_format($total).'</dt>
						</dl>';
						$jumlah_total_beli = cek_valid_stock($id_product_detail,$token,$value['qty']);
					   	
					   	$cek_valid_stock = global_select_single("product_detail_size","*","id = $id_product_detail");
						if($jumlah_total_beli > $cek_valid_stock['stock']){
							echo "<span style='color:red'><strong>Stock ".$product['name']." ".$gender."(".$size.")(".$fit_type.") - (You order ".$jumlah_total_beli." item) please enter ".$cek_valid_stock['stock']." Item Or less</strong></span>";
							$_SESSION['valid_stok'] = 'false';
						}
						echo'	
					</td>
				</tr>';
			}
	
	}else { echo '<span><br />There is no item in your shopping cart</span>'; }
	
}

function cek_valid_stock($id_product_detail,$token,$qty){
	$cek = global_select("shopcart_detail","*","token_head = '$token' AND `id_product_detail` = $id_product_detail");
	$total_beli = 0;
	foreach ($cek as $key => $value) {
		$total_beli = $total_beli + $value['qty'];
	}
	return $total_beli;
}

function table_item_email($token){
	$arr_config = global_select_single('web_config','*');

	$table      = global_select('shopcart_detail','*',"`token_head` = '$token'",'id ASC');
	$other_fee  = global_select_single('order_header','ongkir,handling_fee',"`token` = '$token'");

	$sale_price = 0;
	$grandtotal = 0;
	$tax    = 0;
	
	echo '<table width = "100%" celpadding="5" style="padding:10px;line-height:1.4em">
			<tr>
				<td background-color ="#ccc" width = "40%"><strong>Product</strong></td>
				<td background-color ="#ccc" width = "20%"><strong>Price</strong></td>
				<td background-color ="#ccc" width = "10%"><strong>Qty</strong></td>
				<td background-color ="#ccc" width = "30%"><strong>Subtotal</strong></td>    
			</tr>';
	
	if($table){
		
		foreach($table as $key=>$value){
			
			 $idprod   = $value['idprod'];
			 
			 //fetch prod detail data..
			 $prod_det = global_select_single('product','*',"`id` = $idprod");
			

			 //cek diskon... 
			 if($prod_det['discount_persen'] > 0 ) { 
				$diskon = $prod_det['discount_persen'];
				$sale_price = $prod_det['normal_price'] - ( $prod_det['normal_price'] * $diskon / 100 );

			 }else { $diskon = 0; $sale_price = $prod_det['normal_price']; }
			 //---- 
			
			//itung total
			$total  = $value['qty'] * $sale_price;
			
			//fetch and print table --- 
			 
			echo '<tr>';
				echo '<td><div class="img-wrap">
								<a href="'.$arr_config['website'].'/product-detail/'.$prod_det['urlpage'].'">
									<img width="100" src="'.$arr_config['website'].'/web/'.$prod_det['image'].'" />
								</a>
							</div>
							<h3 class="f-rb"><a href="'.$arr_config['website'].'/product-detail/'.$prod_det['urlpage'].'">'.$prod_det['name'].'</a></h3>
						</td>';

				echo '<td><p>Rp '.number_format($sale_price).'</p></td>';                      
				echo '<td>'.$value['qty'].'</td>';
				echo '<td><strong>Rp '.number_format($total).'</strong></td>';
			echo '</tr>';
			
			 $grandtotal = $grandtotal + $total;
			
			}
			
			
			//UPDATE REQUEST FROM KAU 08/10/2015 SET to ZERO TAX and EXCLUDE handling Fee 
			//untuk shipping Jabodetabek di luar itu ada tax dan handling fee lalu dikurangin 50.000
			//BY HH 151015
			
			//DEFAULT SET:
			//$tax       = $grandtotal * 10/100;
			//$other_fee = $other_fee['ongkir'] + $other_fee['handling_fee'];
			
		
			//UPDATE 29/10/2015 -- REMOVE TAX BY HH
		
			if($other_fee['ongkir'] > 0 ){ 
		
				$tax        = $grandtotal * 10/100;
				$subsidy_fee =  $arr_config['subsidy_fee'];
				$other_fee  = ($other_fee['ongkir'] + $other_fee['handling_fee']);
				
				echo '<tr>';
				echo  '<td colspan = "3">
							<strong>Total</strong><br>
							Shipping + Handling <br />
							Subsidy from Karsamudika <br />
							<span class="greener"><strong>GRAND TOTAL</strong></span>
						</td>
						<td colspan = "1"> 
						<strong>Rp '.number_format($grandtotal).'</strong><br />
								Rp '.number_format($other_fee).'<br />
								<span style="color:red">(Rp '.number_format($subsidy_fee).')</span><br />
								<span class="greener">Rp '.number_format($grandtotal + $other_fee - $subsidy_fee).'</span>
						</td>';
				echo '</tr>';
				
			}else { 
				
				$tax        = 0;
				$other_fee  = $other_fee['ongkir'];
				
				echo '<tr>';
				echo  '<td colspan = "3">
							<strong>Total</strong><br>
							Shipping + Handling<br />
							<span class="greener"><strong>GRAND TOTAL</strong></span>
						</td>
						<td colspan = "1"> 
							<strong>Rp '.number_format($grandtotal).'</strong><br>
								FREE <br>
							<span class="greener">Rp '.number_format($grandtotal + $other_fee).'</span>
						</td>';
				echo '</tr>';
				
			}
			
			//END OF UPDATE -- 
			
			
	
		echo '<tr><td colspan = "4">&nbsp;</td></tr>';
		echo '<tr><td colspan = "4">&nbsp;</td></tr>';
		echo '<tr>';
			echo '<td colspan = "4">
						<a href="'.$arr_config['website'].'/product" class="btn-green2 f-rb">CONTINUE SHOPPING</a>
				  </td>';
		echo '</tr>';
		echo '</table>';
		
		
	}else { echo '<span><br />There is no item in your shopping cart</span>'; }
	
}

function table_item_invoice($id){
	$arr_config = global_select_single('web_config','*');

	$table       = global_select('order_detail','*',"`idorder` = '$id'",'id ASC');
	$other_fee   = global_select_single('order_header','ongkir,handling_fee',"`id` = '$id'");

	$sale_price = 0;
	$grandtotal = 0;
	$tax    = 0;
	
	echo '<table width = "100%" id="items" border="1" cellpadding="5">
			<thead>
				
				<tr>
					<td background-color ="#ccc" width = "40%"><strong>Product</strong></td>
					<td background-color ="#ccc" width = "20%"><strong>Price</strong></td>
					<td background-color ="#ccc" width = "10%" align="center"><strong>Qty</strong></td>
					<td background-color ="#ccc" width = "30%" align="right"><strong>Subtotal</strong></td>    
				</tr>
				
			</thead>';
	
	if($table){
		
		foreach($table as $key=>$value){
			
			 $idprod   = $value['idprod'];
			 
			 //fetch prod detail data..
			 $prod_det = global_select_single('product','*',"`id` = $idprod");
			

			 //cek diskon... 
			 if($prod_det['discount_persen'] > 0 ) { 
				$diskon = $prod_det['discount_persen'];
				$sale_price = $prod_det['normal_price'] - ( $prod_det['normal_price'] * $diskon / 100 );

			 }else { $diskon = 0; $sale_price = $prod_det['normal_price']; }
			 //---- 
			
			//itung total
			$total  = $value['qty'] * $sale_price;
			
			//fetch and print table --- 
			 
			echo '<tr>';
				echo '<td>'.$prod_det['name'].'</td>';

				echo '<td align="right"><p>Rp '.number_format($sale_price).'</p></td>';                      
				echo '<td align="center">'.$value['qty'].'</td>';
				echo '<td align="right"><strong>Rp '.number_format($total).'</strong></td>';
			echo '</tr>';
			
			 $grandtotal = $grandtotal + $total;
			
			}
			
			
			//DEFAULT SET::
			//$tax    = $grandtotal * 10/100; //bisa ambil dari web_config table.
			//$other_fee = $other_fee['ongkir'] + $other_fee['handling_fee'];
			
			//UPDATE REQUEST FROM KAU 08/10/2015 SET to ZERO TAX and EXCLUDE handling Fee 
			//untuk shipping Jabodetabek di luar itu ada tax dan handling fee lalu dikurangin 50.000
			//BY HH 151015
		
			//UPDATE 29/10/2015 -- REMOVE TAX BY HH
		
			if($other_fee['ongkir'] > 0 ){ 
		
				$tax         = $grandtotal * 10/100;
				$subsidy_fee = $arr_config['subsidy_fee'];
				$other_fee   = ($other_fee['ongkir'] + $other_fee['handling_fee']); 
				
				echo '<tr>';
				echo  '<td colspan = "3">
						<strong>Total</strong><br>
						Shipping + Handling <br />
						Subsidy from Karsamudika <br />
						<span class="greener"><strong>GRAND TOTAL</strong></span>
					   </td>
					   <td colspan = "1" align="right"> <strong>Rp '.number_format($grandtotal).'<br>
							Rp '.number_format($other_fee).'<br/>
							<span style="color:red">(Rp '.number_format($subsidy_fee).')</span><br/>
							<span class="greener">Rp '.number_format($grandtotal + $other_fee - $subsidy_fee).'</span>';
				echo '</tr>';
	
				
			}else { 
				
				$tax        = 0;
				$other_fee  = $other_fee['ongkir'];
				
				echo '<tr>';
				echo  '<td colspan = "3">
						<strong>Total</strong><br>
						Shipping + Handling<br />
						<span class="greener"><strong>GRAND TOTAL</strong></span>
					   </td>
					   <td colspan = "1" align="right"> 
						<strong>Rp '.number_format($grandtotal).'<br>
						FREE <br>
						<span class="greener">Rp '.number_format($grandtotal + $other_fee).'</span>';
				echo '</tr>';
				
			}
		
			// END OF UPDATE --
		
			
		echo '</table>';
		
		
	}else { echo '<span><br />There is no item in your shopping cart</span>'; }
	
}
function total_amount_cart($token){
	
	$total = global_select('shopcart_detail,product','shopcart_detail.qty, product.price_normal, product.discount_percent, shopcart_detail.custom_line1, shopcart_detail.custom_line2, shopcart_detail.base_encode,product.price_custom_line1,product.price_custom_line2,product.price_custom_gambar',"shopcart_detail.id_product = product.id AND `token_head` = '$token'");

	$sale_price = 0;
	$total_amount = 0;
	foreach($total as $key => $value){
		$harga_line1 = 0;
		$harga_line2 = 0;
		$harga_gambar = 0;
		
		if($value['custom_line1'] != ''){
			$harga_line1 = $value['price_custom_line1'];
		}
		if($value['custom_line2'] != ''){
			$harga_line2 = $value['price_custom_line2'];
		}
		if($value['base_encode'] != ''){
			$harga_gambar = $value['price_custom_gambar'];
		}

		//cek diskon... 
		if($value['discount_percent'] > 0 ) { 
			$diskon = $value['discount_percent'];
			$sale_price = $value['price_normal'] - ( $value['price_normal'] * $diskon / 100 );
			$sale_price = $sale_price + $harga_gambar + $harga_line2 + $harga_line1;
		}else { 
			$diskon = 0; 
			$sale_price = $value['price_normal']+ $harga_gambar + $harga_line2 + $harga_line1; 
		}
			$total_amount = $total_amount + ($sale_price * $value['qty']);
		}
	return $total_amount;
}

function get_harga_product_order_detail($id,$is_custom,$custom_line1,$custom_line2,$custom_gambar){
	
	$data = global_select_single("product","*","id = $id");
	
		$sale_status = $data["sale_status"];
		$price_normal = $data["price_normal"];
		$discount_percent = $data["discount_percent"];
		
		$harga_line1 = 0;
		$harga_line2 = 0;
		$harga_gambar = 0;
		$total_harga_addon = 0;

		if($is_custom == 1){
			if($custom_line1 != ''){
				$harga_line1 = $data['price_custom_line1'];
			}
			if($custom_line2 != ''){
				$harga_line2 = $data['price_custom_line2'];
			}
			if($custom_gambar != ''){
				$harga_gambar = $data['price_custom_gambar'];
			}
		}

		$total_harga_addon = $harga_line1+$harga_line2+$harga_gambar;

		if($sale_status == 1){
			$harga_product = $price_normal - (($price_normal*$discount_percent) / 100) + $total_harga_addon;
		}else{
			$harga_product = $price_normal + $total_harga_addon;
		}

	return $harga_product;
}

?>