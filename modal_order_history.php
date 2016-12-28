<?php
if($cek_history){ 
	foreach ($cek_history as $key => $value) { ?>
<!-- ORDER & STATUS DETAIL -->
<div class="modal fade orderDetail-modal-<?php echo $value['id'];?>" tabindex="-1" role="dialog" aria-hidden="true">
	<?php 
	$orderid = $value['id'];
	$tanggal = $value['tanggal'];
	$nama_penerima = $value['nama_penerima'];
	$address_penerima = $value['address_penerima'];
	$phone_penerima = $value['phone_penerima'];
	$note = $value['note'];
	$order_amount  		= $value['orderamount'];
	$shippingcost  		= $value['shippingcost'];
	$discountamount  	= $value['discountamount'];
	$vouchercode 	 	= $value['vouchercode'];
	$transfer_amount    = $value['orderamount']+$value['shippingcost']-$value['discountamount'];

	$tokenpay = $value['tokenpay'];
	?>
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="editAddressForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Order #<?php echo $orderid ?></h4>
				</div>
				<div class="modal-body shop">
					<table class="finish-order-table">
						<tr>
							<td colspan="3"><?php echo $tanggal ?></td>
						</tr>
						<tr>
							<th>Order Number</th>
							<td>:</td>
							<td>#<?php echo $orderid ?></td>
						</tr>
						<tr>
							<th>Nama </th>
							<td>:</td>
							<td><?php echo $nama_penerima ?></td>
						</tr>
						<tr>
							<th>Address</th>
							<td>:</td>
							<td><?php echo $address_penerima ?></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td>:</td>
							<td><?php echo $phone_penerima ?></td>
						</tr>
						<tr>
							<th>Shipping Note</th>
							<td>:</td>
							<td><?php echo $note ?></td>
						</tr>
					</table>
					
					<table class="table shop_table cart">
						<thead>
							<tr>
								<th class="product-thumbnail hidden-xs">&nbsp;</th>
								<th class="product-name">Product</th>
								<th class="product-quantity text-center">Qty</th>
								<th class="product-subtotal text-center hidden-xs" style="text-align:right;">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$data_detail 		= global_select("order_detail","*","tokenpay = '".$tokenpay."'");
							if($data_detail){foreach ($data_detail as $key => $value) {
								$product = global_select_single("product","*","id = '$value[idproduct]'");
								$product_detail = global_select_single("product_detail_size","*","id = '$value[iddetail]'");
								
								$gender = get_gender_from_id($product_detail['gender'],'product_gender');
								$size 	= get_size_from_id($product_detail['size'],'product_size');
								$fit_type = get_fit_from_id($product_detail['fit_type'],'product_type');

								if(isset($value['custom_line1']) AND $value['custom_line1'] != ''){
									$custom_line1 = $value['custom_line1'];
									$addon_price1 = $product['price_custom_line1'];
								}
								if(isset($value['custom_line2']) AND $value['custom_line2'] != ''){
									$custom_line2 = $value['custom_line2'];
									$addon_price2 = $product['price_custom_line2'];
								}
								if(isset($value['custom_gambar']) AND $value['custom_gambar'] != ''){
									$custom_gambar = '<img width="100" height="150" src="/web/uploads/'.$value['custom_gambar'].'" width="60px"/>';
									$addon_price_gambar = $product['price_custom_gambar'];
							}
							?>
							<tr class="cart_item">
								<td class="product-thumbnail hidden-xs">
									<a href="#">
										<img width="100" height="150" src="/web/uploads/<?php echo $product['product_image'] ?>" alt="Product-1"/>
									</a>
								</td>
								<td class="product-name">
									<a href="#"><?php echo $product['name'] ?></a>
									<dl class="variation">
										<dt class="variation-Color">Gender:</dt><dd class="variation-Color"><p><?php echo $gender ?></p></dd>
										<dt class="variation-Size">Size:</dt><dd class="variation-Size"><p><?php echo $size ?></p></dd>
										<dt class="variation-Fit">Fit:</dt><dd class="variation-Fit"><p><?php echo $fit_type ?></p></dd>
										<dt class="variation-CustomText">Custom Text Line 1:</dt><dd class="variation-CustomText"><p>Hans Hendrady</p></dd>
										<dt class="variation-CustomText">Custom Text Line 2:</dt><dd class="variation-CustomText"><p>Head Chef</p></dd>
										<dt class="variation-CustomImage">Custom Image:</dt><dd class="variation-CustomImage"><p>No</p></dd>
									</dl>
								</td>
								<td class="product-quantity text-center">
									<strong><?php echo number_format($value['qty']) ?></strong>
								</td>
								<td class="product-subtotal hidden-xs text-center" style="text-align:right;">
									<span class="amount">IDR <?php echo number_format($value['price']*$value['qty']) ?></span>
								</td>
							</tr>

							<?php 
							}}
							?>
							
							<tr>
								<td colspan="6" class="f-g6 finish-fee">
									<strong>TOTAL<span>IDR <?php echo number_format($order_amount) ?></span></strong>
								</td>
							</tr>
							<tr>
								<td colspan="6" class="f-g6 finish-fee">
									SHIPPING FEE<span>IDR <?php echo number_format($shippingcost) ?></span>
								</td>
							</tr>
							<?php if($vouchercode != ''){ ?>
							<tr>
								<td colspan="6" class="f-g6 finish-fee f-green">
									VOUCHER <?php echo $vouchercode ?><span>- IDR <?php echo number_format($discountamount) ?></span>
								</td>
							</tr>
							<?php }?>
							<tr>
								<td colspan="6" class="actions f-g8 cart-gtotal">
									GRAND TOTAL<span>IDR <?php echo number_format($transfer_amount) ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<a href="" data-rel="statusDetailModal" id="<?php echo $orderid ?>" class="btn btn-default btn-outline">View Order Status</a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php }}?>