<?php 
include("header.php"); 
$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING); }
cek_valid_session($token_login);

$member_login = global_select_single("member","*","token = '".$_SESSION['token_login']."'");
if(isset($_GET['halaman'])){ $halaman = $_GET['halaman']; }else{ $halaman = 1; }
$jumlah_data 	= num_rows("order_header","*","idmember = $member_login[id] AND `id` != 1");

$batas			=	10; // limit per page
$posisi			=	pagenum($halaman,$batas);

/*Config*/
$cek_history = global_select("order_header","*,DATE_FORMAT(date,'%W %d %M %Y') as tanggal","idmember = $member_login[id] AND `id` != 1","id ASC LIMIT $posisi,$batas");
?>
	</head>

	<body>
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb">
							<li><span><a href="/<?php echo $curr_lang ?>/index" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span><?php echo $language_config[65]['lang_'.$curr_lang] ?></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div class="row">
								
									<div class="col-sm-3">
										<div class="row">
											<div class="col-sm-12">
												<div class="title">
													<h4><?php echo $language_config[47]['lang_'.$curr_lang] ?></h4>
												</div>
												<div class="separator content_element separator_align_center sep_width_100 sep_pos_align_center separator_no_text">
													<span class="sep_holder sep_holder_l">
														<span class="sep_line"></span>
													</span>
													<span class="sep_holder sep_holder_r">
														<span class="sep_line"></span>
													</span>
												</div>
												<ul class="klassique-side-link f-g8">
													<li><a href="/<?php echo $curr_lang ?>/edit-profile"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[52]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/change-password"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[46]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/address-book"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[64]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/order-history" class="active"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[65]['lang_'.$curr_lang] ?></a></li>
												</ul>
											</div>
										</div>
									</div>
									
									<div class="col-sm-9">
										<div class="wpb_wrapper">
											<div class="row inner">
												<div class="col-sm-12 shop">
													<div class="content_element title">
														<h1><?php echo $language_config[65]['lang_'.$curr_lang] ?></h1>
													</div>
													<table class="table shop_table cart">
														<thead>
															<tr>
																<th class="order-thumbnail hidden-xs">&nbsp;</th>
																<th class="product-name">Order</th>
																<th class="product-quantity">Status Payment</th>
																<th class="product-quantity">Status Delivery</th>
															</tr>
														</thead>
														<tbody>
															<?php
															if($cek_history){foreach ($cek_history as $key => $value) {
																$id_order 		= $value['id'];
																$tokenpay 		= $value['tokenpay'];
																$orderamount 	= $value['orderamount'];
																$shippingcost 	= $value['shippingcost'];
																$discountamount = $value['discountamount'];
																$tanggal 		= $value['tanggal'];
																$status_payment = $value['status_payment'];
																$status_delivery= $value['status_delivery'];
																$total 			= $orderamount+$shippingcost-$discountamount;
																$order_detail = global_select("order_detail","*","tokenpay = '$tokenpay'");
																
																echo'
																<tr class="cart_item">
																	<td class="product-thumbnail hidden-xs" style="vertical-align:top">
																		<a href="#">';
																			if($order_detail){foreach ($order_detail as $key_d => $value_d) {
																				$id_product = $value_d['idproduct'];
																				$data_product = global_select_single("product","*","id = $id_product");
																				echo'<img width="50" src="'.$workdir.'uploads/'.$data_product['product_image'].'" alt="'.$data_product['name'].'" class="order-thumb" />';
																			}}
																			echo'
																		</a>
																	</td>
																	<td class="product-name">
																		<a href="#" class="order-detail-link">#'.$value['id'].'</a><br>
																		'.$tanggal.'
																		<div class="order-table-total">
																			<span class="f-g6">TOTAL</span> <span class="f-g8 f-red">Rp '.number_format($total).'</span>
																		</div><!-- .order-table-total -->
																		<a href="#" data-rel="orderDetailModal" id="'.$value['id'].'" class="f-g6 f-red order-modal-link">View order detail</a>
																	</td>';

																		$data_status = global_select_single("status_detailorder","*","idorder = $id_order");

																	echo'<td style="vertical-align:top;"><span class="f-g8" style="font-size:14px;">'.$status_payment.'</span><br>';
																	echo'<td style="vertical-align:top;"><span class="f-g8" style="font-size:14px;">'.$status_delivery.'</span><br>';
																		if($data_status){echo'<a href="#" data-rel="statusDetailModal" id="'.$value['id'].'" class="f-g6 f-red order-modal-link">View status detail</a>';}
																	echo'
																	</td>
																</tr>';
															}}
															?>
															
														</tbody>
													</table>
													<br>
													<nav class="shop-pagination">
														<div class="paginate">
															<?php 
															echo'<div class="paginate_links">';
															// set berapa jumlah halamannya. diliat dari total row
															$jmlhalaman	=	ceil($jumlah_data/$batas);
															//Modification for looping page number 
															if($halaman < 20) {
																//MODIF RNT
																if($jmlhalaman>20){	
																$startpage = 1; 
																$limitpage = 20; 
																}else{
																$startpage = 1; 
																$limitpage = $jmlhalaman;
																}//END
															}else{
																if($halaman != $jmlhalaman){
																	$startpage = $halaman - 8; 
																	$limitpage = $halaman + 8;
																	if($limitpage > $jmlhalaman){
																		$limitpage = $jmlhalaman;
																	}
																}else{ 
																	$startpage = $halaman - 16;
																	$limitpage = $halaman; 
																}
															} // end of mod ----

															// set default halaman apabila halamannya kosong. otomatis dijadiin 1 kalo nggak. ya default
															if($halaman==''){ $halaman=1; }else{ $halaman=$halaman; }
															// kalo halaman lebih besar dari 1. tombol previous nya nyala
															if($halaman>1){
																$previous=$halaman-1;
																echo'<a class="next page-numbers" href="/'.$curr_lang.'/order-history/'.$previous.'">';
																echo'<i class="fa fa-angle-left"></i>';
															}else{
															}

															if($halaman==''){ $halaman=1; }else{ $halaman=$halaman; }
															for($y=$startpage;$y<=$limitpage;$y++){
																if($y!=$halaman){
																	echo'<a class="page-numbers" href="/'.$curr_lang.'/order-history/'.$y.'">'.$y.'</a>';
																}else{
																	echo'<span class="page-numbers current">'.$y.'</span>';
																}
															}

															// kalo halaman kecil. tombol next aktiv
															if($halaman < $jmlhalaman){
																$next=$halaman+1;
																echo'<a class="next page-numbers" href="/'.$curr_lang.'/order-history/'.$next.'">';
																echo'<i class="fa fa-angle-right"></i>';
															}else{
															}
															echo'</a>';
															echo'</div>';
															?>
														</div>
													</nav>
												</div>
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
		<?php include("modal_order_history.php"); ?>
		<?php include("modal_status_detail.php"); ?>
		<?php include("modal.php"); ?>
		<?php include("footer.php"); ?>

<script>
	$(document).ready(function() {
		$("header").removeClass("header-absolute header-transparent");
	});
</script>
</body>
</html>