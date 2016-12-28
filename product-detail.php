<?php 
include("header.php"); 
/*used Variable*/
$id_product 	= '';
$urlpage 		= '';
$product 		= '';
$id_category 	= '';
$category 		= '';
$image_section1 = '';

/*Security config*/
if(isset($_GET['urlpage'])){$urlpage = filter_var($_GET['urlpage'],FILTER_SANITIZE_STRING);}
$id_product = get_id_from_urlpage($urlpage,'product');
if($id_product == NULL){redirect('/'.$curr_lang.'/product-list');}

/*data product*/
$product 	= global_select_single("product","*","id = $id_product");
$discount_percent 	= $product['discount_percent'];
$discount_value 	= ($product['price_normal']*$discount_percent)/100;
$sale_price			= $product['price_normal']-$discount_value;

/*get id category*/
$id_category = $product['category'];
$category = global_select_single("product_category","urlpage,title","id = $id_category");

/*product image untuk Section 1*/
$image_section1 = global_select("product_image","*","id_product = $id_product");

/*query master gender*/
$gender = global_select("product_gender","`id`,`title`");

/*halaman dibawah. bagian tab tab*/
$description_tab 		= global_select_single("product_description","*","id_product = $id_product");
$product_additional_information_tab = global_select("product_additional_information","*","id_product = $id_product");
$product_review 		= global_select("product_review","*,DATE_FORMAT(`modified_datetime`,'%d %M %Y') as `tanggal`","id_product = $id_product AND publish = 1");
$product_review_total 	= num_rows("product_review","*","id_product = $id_product AND publish = 1");
$id_product_related 	= global_select("product_related","id_product_related","id_product = $id_product");

/*pages*/
$pages_product_bordir = global_select_single("pages","*","id = 2");
?>

	</head>

	<script type="text/javascript">

	$(window).load(function() {
		var selected = $(".swatch-wrapper").attr('id');
		//$(".addtocart").prop('disabled', true);
		$("#ukuran_size").val(selected);
	});

	function fbShare(url, winWidth, winHeight) {
		var winTop = (screen.height / 2) - (winHeight / 2);
		var winLeft = (screen.width / 2) - (winWidth / 2);
		window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	}

	function TwitShare(url, winWidth, winHeight) {
		var winTop = (screen.height / 2) - (winHeight / 2);
		var winLeft = (screen.width / 2) - (winWidth / 2);
		window.open('https://twitter.com/share?url=' + url,'sharer','top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	}

	function GplusShare(url, winWidth, winHeight) {
		var winTop = (screen.height / 2) - (winHeight / 2);
		var winLeft = (screen.width / 2) - (winWidth / 2);
		window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=' + url,'sharer','top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	}

	function linkinShare(url, winWidth, winHeight) {
		var winTop = (screen.height / 2) - (winHeight / 2);
		var winLeft = (screen.width / 2) - (winWidth / 2);
		window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + url,'sharer','top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	}

	</script>
	<span id="language_current" style="display:none" lang="<?php echo $curr_lang ?>"></span>
	<span id="display_lang_size" style="display:none" lang="<?php echo $language_config[80]['lang_'.$curr_lang] ?>"></span>


	<body class="shop">
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb">
							<li><span><a href="/<?php echo $curr_lang ?>/index" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span><a href="/<?php echo $curr_lang ?>/product-list?view=filter&category=chef-coats&halaman=1"><span><?php echo $category['title'] ?></span></a></span></li>
							<li><span><?php echo $product['name'] ?></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container-full">
					<div class="row">
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div class="container">
									<div class="row">
										<div class="col-md-12 no-min-height"></div>
									</div>
								</div>
								<div class="product">
									<div class="container">
										<div class="row summary-container">
											<!-- Section 1 -->
											<div class="col-md-8 col-sm-6 entry-image">
												<div class="pdtl">
													<div class="pdtl-large">
														<div class="img-wrap">
															<?php if($image_section1[0]){ ?>
															<img id="zoom_01" class="zoomable" src="<?php echo $workdir ?>uploads/<?php echo $image_section1[0]['image_large'] ?>" data-zoom-image="<?php echo $workdir ?>uploads/<?php echo $image_section1[0]['image_large'] ?>" />
															<?php }?>
															<div class="product-badge">
															<?php 
																if($product['best_status'] == 1){
																	echo'<span class="pb-best">Best</span>';
																}
																if($product['new_status'] == 1){
																	echo'<span class="pb-new">New</span>';
																}
																if($product['sale_status'] == 1){
																	echo'<span class="pb-sale">Sale</span>';
																}
															?>
															</div><!-- .product-bage -->
														</div><!-- .img-wrap -->
													</div><!-- .pdtl-large -->
													
													<div id="gallery_01" class="pdtl-thumb">
														<?php if($image_section1){ foreach ($image_section1 as $key => $value) {?>
														<a href="#" data-image="<?php echo $workdir ?>uploads/<?php echo $value['image_large'] ?>" data-zoom-image="<?php echo $workdir ?>uploads/<?php echo $value['image_large'] ?>">
															<img src="<?php echo $workdir ?>uploads/<?php echo $value['image_small'] ?>" />
														</a>
														<?php }}?>
													
													</div><!-- .pdtl-thumb -->
												</div><!-- .pdtl -->
											</div><!-- .entry-image -->
											
											<div class="col-md-4 col-sm-6 entry-summary">
												<div class="summary">
													<h1 class="product_title entry-title"><?php echo $product['name'] ?></h1>
													<div class="shop-product-rating">
														<div class="prod-raty" data-score="4.5"></div>
													</div>
													<?php if($product['sale_status'] == 1){
														echo '<p class="price"><del><span>IDR '.number_format($product['price_normal']).'</span></del>&nbsp;&nbsp;<span class="amount">IDR '.number_format($sale_price).'</span></p>';
													}else{
														echo '<p class="price"><span class="amount">IDR '.number_format($product['price_normal']).'</span></p>';
													} ?>
													<div class="product-excerpt">
														<p><?php echo $product['short_description'] ?></p>
													</div>
													<div class="product-actions res-color-attr">
														<form class="cart" method="post" id="form_cart" enctype="multipart/form-data">
															<input type="hidden" name="id_product" id="id_product" value="<?php echo $id_product ?>">
															<input type="hidden" name="id_product_detail" id="ukuran_size" value="">

															<div class="product-options-outer">
																<div class="variation_form_section">
																	<div class="product-options icons-lg">
																		<table class="variations-table">
																			<tbody>
																				<tr id="filter_gender_prod_detail">
																					<td><label><?php echo $language_config[54]['lang_'.$curr_lang] ?></label></td>
																					<td>
																						<div class="form-flat-select" style="margin-bottom:10px;">
																							<select name="gender" id="cek_detail_gender">
																								<option>- Please Select -</option>
																								<?php 
																								if($gender){
																									foreach ($gender as $key_g => $value_g) {
																										echo "<option value='".$value_g['id']."'>".$value_g['title']."</option>";
																									}
																								}
																								?>
																							</select>
																						</div>
																					</td>
																				</tr>
																				<tr id="filter_fit_prod_detail">
																					<td><label>Fit</label></td>
																					<td>
																						<div class="form-flat-select" style="margin-bottom:10px;">
																							<select name="fit_type" class="filter_type" id="cek_detail_fit">
																								<option>- Please Select -</option>
																							</select>
																						</div>
																					</td>
																				</tr>
																				<tr id="filter_size_prod_detail" class="filter_size">

																				</tr>
																				<tr>
																					<td></td>
																					<td><a href="#" data-rel="measurementModal" class="link-measure-guide"><?php echo $language_config[67]['lang_'.$curr_lang] ?></a></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
															<div class="custom-order-area">
																<div class="custom-checkbox" id="custom_checkbox_bordir">
																	<input id="custom-embroidery" type="checkbox" />&nbsp;&nbsp;
																	<label for="custom-embroidery"><?php echo $language_config[82]['lang_'.$curr_lang] ?></label>
																</div><!-- .custom-checkbox -->
																<div class="hidden-custom-order">
																	<?php echo $pages_product_bordir['description_'.$curr_lang] ?>
																	<a href="#" data-rel="custombordirmodal" class="link-measure-guide"><?php echo $language_config[101]['lang_'.$curr_lang] ?></a>
																	<div class="custom-text">
																		<div class="custom-checkbox">
																			<input id="custom-text1" type="checkbox" name="check_line1" class="toggle-custom check_cheked" nominal="<?php echo $product['price_custom_line1'] ?>" />&nbsp;&nbsp;
																			<label for="custom-text1"><?php echo $language_config[86]['lang_'.$curr_lang] ?></label>
																		</div><!-- .custom-checkbox -->
																		<div class="custom-content-detail">
																			<div class="form-group">
																				<label><small style="color:#F00"><?php echo $language_config[89]['lang_'.$curr_lang] ?> IDR <?php echo number_format($product['price_custom_line1']) ?></small></label>
																				<input type="text" name="value_line1" placeholder="Max. 16 characters" class="form-control text" />
																				<input type="radio" name="style_line1" value="Block">&nbsp;<strong>Block</strong>&nbsp;</input>
																				<input type="radio" name="style_line1" value="Italic">&nbsp;<i>Italic</i>&nbsp;</input>
																			</div><!-- .form-group -->
																		</div><!-- .custom-content-detail -->
																	</div><!-- .custom-text -->
																	<div class="custom-text">
																		<div class="custom-checkbox">
																			<input id="custom-text2" type="checkbox" name="check_line2" class="toggle-custom check_cheked" nominal="<?php echo $product['price_custom_line2'] ?>"/>&nbsp;&nbsp;
																			<label for="custom-text2"><?php echo $language_config[87]['lang_'.$curr_lang] ?></label>
																		</div><!-- .custom-checkbox -->
																		<div class="custom-content-detail">
																			<div class="form-group">
																				<label><small style="color:#F00"><?php echo $language_config[89]['lang_'.$curr_lang] ?> IDR <?php echo number_format($product['price_custom_line2']) ?></small></label>
																				<input type="text" name="value_line2" placeholder="Max. 16 characters" class="form-control text" />
																				<input type="radio" name="style_line2" value="Block">&nbsp;<strong>Block</strong>&nbsp;</input>
																				<input type="radio" name="style_line2" value="Italic">&nbsp;<i>Italic</i>&nbsp;</input>
																			</div><!-- .form-group -->
																		</div><!-- .custom-content-detail -->
																	</div><!-- .custom-text -->
																	<div class="custom-image">
																		<div class="custom-checkbox">
																			<input id="custom-image" type="checkbox" name="check_image" class="toggle-custom check_cheked" nominal="<?php echo $product['price_custom_gambar'] ?>"/>&nbsp;&nbsp;
																			<label for="custom-image"><?php echo $language_config[88]['lang_'.$curr_lang] ?></label>
																		</div><!-- .custom-checkbox -->
																		<div class="custom-content-detail">
																			<div class="form-group">
																				<label><small style="color:#F00"><?php echo $language_config[89]['lang_'.$curr_lang] ?> IDR <?php echo number_format($product['price_custom_gambar']) ?></small></label>
																				<input type="file" name="gambar" class="" />
																				<small class="f-g6" style="font-size:.8em; font-style:italic;">* <?php echo $language_config[93]['lang_'.$curr_lang] ?></small>
																			</div><!-- .form-group -->
																			<div class="form-group">
																				<label><?php echo $language_config[91]['lang_'.$curr_lang] ?></label>
																				<div class="form-flat-select">
																					<select style="width:100%" name="image_position">
																						<option value="top-left-chest">Top-left Chest</option>
																						<option value="top-right-chest">Top-right Chest</option>
																						<option value="top-left-arm">Top-left Arm</option>
																						<option value="top-right-arm">Top-right Arm</option>
																					</select>
																				</div>
																			</div><!-- .form-group -->
																		</div><!-- .custom-content-detail -->
																	</div><!-- .custom-image -->
																	<div class="custom-cost f-g8">
																		<?php echo $language_config[90]['lang_'.$curr_lang] ?>:
																		<span id="total_biaya_tambahan">IDR 0</span>
																	</div><!-- .custom-cost -->
																</div><!-- .hidden-custom-order -->
															</div><!-- .custom-order-area -->
															<div class="single_variation_wrap">
																<br>
																<div class="variations_button">
																	<div class="quantity">
																		<input type="number" id="max_value_buy" name="quantity" value="1" min="1" title="Qty" class="input-text qty text" size="4">
																	</div>
																	<button type="submit" class="button f-g8 addtocart"><?php echo $language_config[81]['lang_'.$curr_lang] ?></button>
																</div>
															</div>
														</form>
													</div>
													<div class="product_meta">
														<span class="sku_wrapper">SKU: <span class="sku"><?php echo $product['sku'] ?></span></span>
														<span class="posted_in">Category: <a href="/<?php echo $curr_lang ?>/product-list?view=filter&category=<?php echo $category['urlpage'] ?>"><?php echo $category['title'] ?></a></span>
													</div>
													<div class="share-links">
														<div class="share-icons">
															<span class="facebook-share">
																<a href="javascript:fbShare('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>',520, 350)" display="popup" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
															</span>
															<span class="twitter-share">
																<a href="javascript:TwitShare('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>', 520, 350)" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
															</span>
															<span class="google-plus-share">
																<a href="javascript:GplusShare('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>', 520, 350)" title="Share on Google +"><i class="fa fa-google-plus"></i></a>
															</span>
															<span class="linkedin-share">
																<a href="javascript:linkinShare('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>', 520, 350)" title="Share on Linked In"><i class="fa fa-linkedin"></i></a>
															</span>
														</div>
													</div>
												</div> 
											</div>
										</div>
									</div>
									<div class="shop-tab-container">
										<div class="container">
											<div class="row">
												<div class="col-md-12">
													<div class="tabbable shop-tabs">
														<ul class="nav nav-tabs" role="tablist">
															<li class="active">
																<a data-toggle="tab" role="tab" href="#tab-description"><?php echo $language_config[84]['lang_'.$curr_lang] ?></a>
															</li>
															<li>
																<a data-toggle="tab" role="tab" href="#tab-additional_information"><?php echo $language_config[85]['lang_'.$curr_lang] ?></a>
															</li>
															<li>
																<a data-toggle="tab" role="tab" href="#tab-reviews">Reviews (<?php echo $product_review_total ?>)</a>
															</li>
														</ul>
														<div class="tab-content">
															<div class="tab-pane active" id="tab-description">
																<h2>Product Description</h2>
																<h3><?php echo $description_tab['title_'.$curr_lang] ?></h3>
																<img class="alignright" src="<?php echo $workdir ?>uploads/<?php echo $description_tab['image'] ?>" alt="img" />
																<?php echo $description_tab['description_'.$curr_lang] ?>
															</div>
															<div class="tab-pane" id="tab-additional_information">
																<h2>Additional Information</h2>
																<table class="shop_attributes">
																	<?php if($product_additional_information_tab){ foreach ($product_additional_information_tab as $key_a => $value_a) {
																	echo'
																	<tr class="">
																		<th>'.$value_a['info_'.$curr_lang].'</th>
																		<td><p>'.$value_a['description_'.$curr_lang].'</p></td>
																	</tr>';
																	}}?>		
																</table>
															</div>
															<div class="tab-pane" id="tab-reviews">
																<div id="reviews">
																	<div id="comments">
																		<h2><?php echo $product_review_total ?> review for White Chef Coat Standard</h2>
																		<ol class="commentlist">
																			<?php if($product_review){ foreach ($product_review as $key_r => $value_r) {
																			echo'
																			<li>
																				<div class="comment_container">
																					<div class="comment-text">
																						<div class="star-rated">';
																							//<div class="prod-raty" data-score="'.$value_r['rating'].'"></div>
																							echo'
																						</div>
																						<p class="meta">
																							<strong>'.$value_r['user_name'].'</strong> &ndash; <time datetime="'.$value_r['modified_datetime'].'">'.$value_r['tanggal'].'</time>:
																						</p>
																						<div class="description"><p>'.$value_r['comment'].'</p></div>
																					</div>
																				</div>
																			</li>';
																			}} ?>
																		</ol>
																	</div>
																	<div id="respond-wrap">
																		<div id="respond" class="comment-respond">
																			<h3 class="comment-reply-title">
																				<span><?php echo $language_config[77]['lang_'.$curr_lang] ?></span>
																			</h3>
																			<form class="comment-form" method="POST" action="/<?php echo $curr_lang ?>/member-review">
																				<input type="hidden" name="id_product" value="<?php echo $id_product ?>">
																				<p class="comment-form-name">
																					<!-- <label><?php echo $language_config[78]['lang_'.$curr_lang] ?></label> -->
																					<!-- <div class="raty-rating"></div> -->
																				</p>
																				<p class="comment-form-comment">
																					<label><?php echo $language_config[79]['lang_'.$curr_lang] ?></label>
																					<textarea class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea>
																				</p>
																				<p>
																					<input name="submit" class="btn f-g8" value="<?php echo $language_config[44]['lang_'.$curr_lang] ?>" type="submit" />
																				</p>
																			</form>
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
									<div class="container">
										<div class="row">
											<div class="col-sm-12">
												<div class="related products">
													<div class="related-title">
														<h3><span><?php echo $language_config[83]['lang_'.$curr_lang] ?></span></h3>
													</div>
													<ul class="products columns-4" data-columns="4">
														
														<?php if($id_product_related){ foreach ($id_product_related as $key_idrel => $value_idrel) { 
															$data_product_related = global_select_single("product","*","id = ".$value_idrel['id_product_related']);

															$discount_percent 	= $data_product_related['discount_percent'];
															$discount_value 	= ($data_product_related['price_normal']*$discount_percent)/100;
															$sale_price			= $data_product_related['price_normal']-$discount_value;
														?>
														<li class="product">
															<div class="product-container">
																<figure>
																	<div class="product-wrap">
																		<div class="product-images">
																			<div class="product-badge">
																				<?php 
																				if($data_product_related['best_status'] == 1){
																					echo'<span class="pb-best">Best</span>';
																				}
																				if($data_product_related['new_status'] == 1){
																					echo'<span class="pb-new">New</span>';
																				}
																				if($data_product_related['sale_status'] == 1){
																					echo'<span class="pb-sale">Sale</span>';
																				}?>
																			</div><!-- .product-bage -->
																			<div class="shop-loop-thumbnail">
																				<a href="/<?php echo $curr_lang ?>/product-detail/<?php echo $data_product_related['urlpage'] ?>"><img width="300" height="350" src="<?php echo $workdir ?>images/klassique/product/thumb2.png" alt="Product-3"/></a>
																			</div>
																		</div>
																	</div>
																	<figcaption>
																		<div class="shop-loop-product-info">
																			<div class="info-title">
																				<h3 class="product_title"><a href="/<?php echo $curr_lang ?>/product-detail/<?php echo $data_product_related['urlpage'] ?>"><?php echo $data_product_related['name'] ?></a></h3>
																			</div>
																			<div class="info-meta">
																				<div class="info-price">
																					<span class="price">
																						<?php if($data_product_related['sale_status'] == 1){
																							echo '<del><span>IDR '.number_format($data_product_related['price_normal']).'</span></del>&nbsp;&nbsp;<span class="amount">IDR '.number_format($sale_price).'</span>';
																						}else{
																							echo '<span>IDR '.number_format($data_product_related['price_normal']).'</span>';
																						} ?>
																					</span>
																				</div>
																				<div class="loop-add-to-cart">
																					<a href="/<?php echo $curr_lang ?>/product-detail/<?php echo $data_product_related['urlpage'] ?>"><?php echo $language_config[92]['lang_'.$curr_lang] ?></a>
																				</div>
																			</div>
																			<div class="prod-raty" data-score="<?php echo $data_product_related['rating'] ?>"></div>
																		</div>
																	</figcaption>
																</figure>
															</div>
														</li>
														<?php }}?>
													</ul>
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
		<?php include("modal.php"); ?>
		<?php include("footer.php"); ?>
<script>
	$(document).ready(function() {
		$("header").removeClass("header-absolute header-transparent");
		
		// custom order check
		if ($("#custom-embroidery").is(':checked')) {
			$("#custom-embroidery").parent(".custom-checkbox").next(".hidden-custom-order").show("fast");
		} else {
			$("#custom-embroidery").parent(".custom-checkbox").next(".hidden-custom-order").hide("fast");
		}
		$("input#custom-embroidery").change(function () {
			if ($(this).is(':checked')) {
				$(this).parent(".custom-checkbox").next(".hidden-custom-order").slideDown("fast");
			}
			else {
				$(this).parent(".custom-checkbox").next(".hidden-custom-order").slideUp("fast");
			}
		});
		
		$('input.toggle-custom').each(function(){
			var dis = $(this);
			if (dis.is(':checked')) {
				dis.parent(".custom-checkbox").next(".custom-content-detail").show("fast");
			} else {
				dis.parent(".custom-checkbox").next(".custom-content-detail").hide("fast");
			}
		});
		$("input.toggle-custom").change(function () {
			if ($(this).is(':checked')) {
				$(this).parent(".custom-checkbox").next(".custom-content-detail").slideDown("fast");
			}
			else {
				$(this).parent(".custom-checkbox").next(".custom-content-detail").slideUp("fast");
			}
		});
	});
	$(window).load(function() {
		$("#zoom_01").elevateZoom({
			responsive:'true',
			gallery:'gallery_01',
			cursor: 'pointer',
			zoomType : "inner",
			galleryActiveClass: 'active',
			imageCrossfade: true,
			zoomWindowOffetx:35,
			zoomWindowOffety:0,
			borderSize:0,
			zoomWindowFadeIn: 300, zoomWindowFadeOut: 30, lensFadeIn: 300, lensFadeOut: 300,
			loadingIcon: '/images/spinner.gif'
		});
	});
	$(window).bind("resize", function(){ // scroll event
		$('.pdtl-large .img-wrap').each(function() {
			var dwidth = $(this).width();
			var dHeight = $(this).height();
			$(".zoomContainer").css({"width" : dwidth+2, "height" : dHeight+2}); // +2 becoz of border
		});
	});
</script>
</body>
</html>