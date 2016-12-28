<?php 
include("header.php"); 
include("config/function_product.php"); 


/*declare used var*/
$best 				= '';
$sale 				= '';
$new 				= '';
$show_result 		= '';
$price_filter_min 	= '';
$price_filter_max 	= '';
$sql_between_price  = '';
$sql_sort  			= 'ORDER BY `product`.`sortnumber` ASC';
$sql_size  			= '';
$halaman 			= '';
$kategori 			= '';
$sql_kategori 		= '';
$sql_gender			= '';
$sql_fit			= '';
$id_kategori		= '';
$sort 				= '';

$price 				= '';
$gender 			= '';
$size 				= '';
$fit 				= '';
$category 			= '';
$sort 				= '';
$halaman 			= '';
$select_style 		= '';
$breadcrumb 		= '';
$ket_size			= '';
$ket_price 			= '';
$ket_gender			= '';
$ket_fit			= '';
$ket_key			= '';
$keyword		 	= '';
$sql_keyword	 	= '';

$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


if(isset($_GET['halaman'])){ $halaman = $_GET['halaman']; }

if(isset($_POST['keyword'])){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$sql_keyword = "AND `name` LIKE '%".$keyword."%'"; 
	$ket_key = '| keyword = '.$keyword;
}

if(isset($_GET['keyword'])){
	$keyword = filter_var($_GET['keyword'],FILTER_SANITIZE_STRING);
	$sql_keyword = "AND `name` LIKE '%".$keyword."%'"; 
	$ket_key = '| keyword = '.$keyword;
}

if(isset($_GET['sort'])){ 
	$sort = $_GET['sort']; 
	if($sort == 'newness'){
		$sql_sort = "ORDER BY `product`.`id` DESC";
	}elseif ($sort == 'price') {
		$sql_sort = "ORDER BY `product`.`price_normal` ASC";
	}elseif ($sort == 'price-desc') {
		$sql_sort = "ORDER BY `product`.`price_normal` DESC";
	}elseif ($sort == 'rating') {
		$sql_sort = "ORDER BY `product`.`rating` DESC";
	}
}
if(isset($_GET['size'])){ 
	$size = $_GET['size']; 
	$id_size = get_idsize_from_urlpage($size,'product_size');
	$sql_size = "AND `product_detail_size`.`size` = $id_size";
	$ket_size = "size ($size)";
}
if(isset($_GET['price'])){ 
	$price = $_GET['price'];
	$split = explode('-',$price);
	$price_filter_min = $split[0];
	$price_filter_max = $split[1];
	$sql_between_price = "AND `product`.`price_normal` BETWEEN $price_filter_min AND $price_filter_max";
	$ket_price = 'Price between '.number_format($price_filter_min).' to '.number_format($price_filter_max).'';
}
if(isset($_GET['fit'])){ 
	$fit = $_GET['fit'];
	$id_fit = get_fit_from_urlpage($fit,'product_type');
	$sql_fit = "AND `product_detail_size`.`fit_type` = '$id_fit'";
	$ket_fit = "Fit = ".$fit;
}
if(isset($_GET['gender'])){ 
	$gender = $_GET['gender']; 
	$id_gender	= get_gender_from_urlpage($gender,'product_gender');
	$sql_gender = "AND `product_detail_size`.`gender` = $id_gender";
	if($gender == 'All'){
		$sql_gender = "";
	}
	$ket_gender = "gender = ".$gender;
}
if(isset($_GET['category']) AND $_GET['category'] != 1){ 
	$kategori		= $_GET['category'];
	$id_kategori	= get_id_from_urlpage($kategori,'product_category');
	$sql_kategori	= "AND `product`.`category` = $id_kategori";
}else{
	$kategori = 1;
}

$sql_filter = $sql_keyword.' '.$sql_kategori.' '.$sql_gender.' '.$sql_fit.' '.$sql_between_price.' '.$sql_size;

/*paging & show data product*/
$get_data_jumlah = select_custom("SELECT `product_detail_size`.`size`,`product`.* FROM `product` LEFT JOIN `product_detail_size` ON `product_detail_size`.`id_product` = `product`.`id` WHERE 1=1 $sql_filter GROUP BY `product`.`id` ORDER BY `product`.`sortnumber` ASC");
$jumlah_data 	= 	$get_data_jumlah['total'];
$batas			=	10; // limit per page
$posisi			=	pagenum($halaman,$batas);

$banner 		= global_select_single("product_banner","*");
$product 		= select_custom("SELECT `product_detail_size`.`size`,`product`.* FROM `product` LEFT JOIN `product_detail_size` ON `product_detail_size`.`id_product` = `product`.`id` WHERE 1=1 $sql_filter GROUP BY `product`.`id` $sql_sort LIMIT $posisi,$batas");
$jumlah_data_tampil 	= $product['total'];

/*categories*/
$product_category = global_select("product_category","*","publish = 1"); 

/*show status*/
$show_result 	=	"Showing 1 - ".$jumlah_data_tampil." of ".$jumlah_data." results";

if($jumlah_data_tampil == 0){
	$show_result = 'No Result';
}



$populate = select_custom("SELECT CASE WHEN `sale_status` = 1 THEN (`price_normal` - ((`price_normal` * `discount_percent`) / 100)  ) WHEN `sale_status` = 0 THEN `price_normal` END AS `sale_price` FROM `product`");
foreach ($populate['row'] as $key => $value) {
	foreach ($value as $key2 => $value2) {
		$pop[$key] = $value2; 
	}
}
$max = MAX($pop);
$min = MIN($pop);

$breadcrumb = "Showing Product List : ".$ket_size.' '.$ket_price.' '.$ket_gender.' '.$ket_fit.' '.$ket_key;

?>

<input type="hidden" id="hidden_curr_lang"		value="<?php echo $curr_lang ?>">
<input type="hidden" id="hidden_curr_page"		value="product-list">
<input type="hidden" id="hidden_price_range"	value="<?php echo $price ?>">
<input type="hidden" id="hidden_gender"			value="<?php echo $gender ?>">
<input type="hidden" id="hidden_size" 			value="<?php echo $size ?>">
<input type="hidden" id="hidden_fit" 			value="<?php echo $fit ?>">
<input type="hidden" id="hidden_category" 		value="<?php echo $kategori ?>">
<input type="hidden" id="hidden_sort" 			value="<?php echo $sort ?>">
<input type="hidden" id="hidden_halaman"		value="<?php echo $halaman ?>">
<input type="hidden" id="hidden_keyword"		value="<?php echo $keyword ?>">


	</head>
	
<script type="text/javascript">
	
</script>

	<body class="shop page-layout-left-sidebar">
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container heading-resize heading-no-button">
				<div class="heading-background heading-parallax bg-1" style="background-image:url(<?php echo $workdir ?>images/klassique/banner/shop-banner.jpg)">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="heading-wrap">
									<div class="page-title">
										<h1 class="f-g8"><?php echo $banner['title_'.$curr_lang] ?></h1>
										<div class="page-breadcrumb">
											<ul class="breadcrumb f-g6">
												<li><span><a class="home" href="/<?php echo $curr_lang ?>/index"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
												<li><span><?php echo $banner['title_'.$curr_lang] ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="shop-toolbar">
				<div class="container">
					<div class="row">
						<div class="col-md-9 main-wrap pull-right">
							<form class="shop-ordering clearfix">
								<div class="shop-ordering-select">
									<label class="hide">Sorting:</label>
									<div class="form-flat-select">
										<select name="orderby" class="orderby sorting" id="sorting">
											<option value="menu_order" <?php echo is_selected('menu_order',$sort) ?>>Default sorting</option>
											<option value="popularity" <?php echo is_selected('popularity',$sort) ?>>Sort by popularity</option>
											<option value="rating" <?php echo is_selected('rating',$sort) ?>>Sort by average rating</option>
											<option value="newness" <?php echo is_selected('newness',$sort) ?>>Sort by newness</option>
											<option value="price" <?php echo is_selected('price',$sort) ?>>Sort by price: low to high</option>
											<option value="price-desc" <?php echo is_selected('price-desc',$sort) ?>>Sort by price: high to low</option>
										</select>
										<i class="fa fa-angle-down"></i>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-md-9 main-wrap">
							<div class="main-content">
								<div class="shop-loop grid">
									<p><?php echo $breadcrumb ?></p>
									<ul class="products">
										
										<?php 
										if($product){ foreach ($product['row'] as $key => $value) {
											
											if($value['best_status'] == 1){
												$best = '<span class="pb-best">Best</span>';
											}
											if($value['new_status'] == 1){
												$new = '<span class="pb-new">New</span>';
											}
											if($value['sale_status'] == 1){
												$sale = '<span class="pb-sale">Sale</span>';
											}

											$discount_percent 	= $value['discount_percent'];
											$discount_value 	= ($value['price_normal']*$discount_percent)/100;
											$sale_price			= $value['price_normal']-$discount_value;

											echo'
											<li class="product">
												<div class="product-container">
													<figure>
														<div class="product-wrap">
															<div class="product-images">
																<div class="product-badge">
																	'.$best.'
																	'.$sale.'
																	'.$new.'
																</div><!-- .product-bage -->
																<div class="shop-loop-thumbnail">
																	<a href="/'.$curr_lang.'/product-detail/'.$value['urlpage'].'"><img width="300" height="350" src="'.$workdir.'uploads/'.$value['product_image'].'" alt="'.$value['name'].'"/></a>
																</div>
															</div>
														</div>
														<figcaption>
															<div class="shop-loop-product-info">
																<div class="info-title">
																	<h3 class="product_title"><a href="/'.$curr_lang.'/product-detail/'.$value['urlpage'].'">'.$value['name'].'</a></h3>
																</div>
																<div class="info-meta">
																	<div class="info-price">
																		<span class="price">';
																			
																			if($value['sale_status'] == 1){
																				echo '<del><span class="amount">IDR '.number_format($value['price_normal']).'</span></del> <ins><span class="amount">IDR '.number_format($sale_price).'</span></ins>';
																			}else{
																				echo'<span class="amount">IDR '.number_format($value['price_normal']).'</span>';
																			}
																			
																			echo'
																		</span>
																	</div>
																	<div class="loop-add-to-cart">
																		<a href="/'.$curr_lang.'/product-detail/'.$value['urlpage'].'">View Details</a>
																	</div>
																</div>
																<div class="prod-raty" data-score="'.$value['rating'].'"></div>
															</div>
														</figcaption>
													</figure>
												</div>
											</li>
											';
										}}?>
										
									</ul>
								</div>
								<nav class="shop-pagination">
									<p class="shop-result-count">
										<?php echo $show_result; ?>
									</p>
									<div class="paginate">
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
													echo'<a class="next filter page-numbers" hal="'.$previous.'" href="#">';
													echo'<i class="fa fa-angle-left"></i>';
												}else{
												}

												if($halaman==''){ $halaman=1; }else{ $halaman=$halaman; }
												for($y=$startpage;$y<=$limitpage;$y++){
													if($y!=$halaman){
														echo'<a class="filter page-numbers" hal="'.$y.'" href="#">'.$y.'</a>';
													}else{
														echo'<span class="page-numbers current">'.$y.'</span>';
													}
												}

												// kalo halaman kecil. tombol next aktiv
												if($halaman < $jmlhalaman){
													$next=$halaman+1;
													echo'<a class="next filter page-numbers" hal="'.$next.'" href="#">';
													echo'<i class="fa fa-angle-right"></i>';
												}else{
												}
												echo'</a>';
												echo'</div>';
												?>
											</div>
									</div>
								</nav>
							</div>
						</div>
						<div class="col-md-3 sidebar-wrap">
							<div class="main-sidebar">
								<div class="widget shop widget_price_filter">
									<h4 class="widget-title"><span>Price</span></h4>
									<form class="filter-form">
										<div class="price_slider_wrapper">
											<div class="price_slider"></div>
											<div class="price_slider_amount">
												<input type="text" id="min_price" name="min_price" value="<?php echo $price_filter_min ?>" val_calc="<?php echo $price_filter_min ?>" data-min="<?php echo $min ?>" placeholder="Min price"/>
												<input type="text" id="max_price" name="max_price" value="<?php echo $price_filter_max ?>" val_calc="<?php echo $price_filter_max ?>" data-max="<?php echo $max ?>" placeholder="Max price"/>
												<div class="price_label">
													Price: <span class="from"></span> &mdash; <span class="to"></span>
												</div>
												<button type="submit" class="button">Filter</button>
												<div class="clear"></div>
											</div>
										</div>
									</form>
								</div>
								<div class="widget shop widget_product_tag_cloud">
									<h4 class="widget-title"><span>Gender</span></h4>
									<div class="tagcloud">
										<a href="#" class="filter gender" <?php if($gender == 'Men'){echo 'style="border-color:black"';} ?>>Men</a>
										<a href="#" class="filter gender" <?php if($gender == 'Women'){echo 'style="border-color:black"';} ?>>Women</a>
										<a href="#" class="filter gender" <?php if($gender == 'All'){echo 'style="border-color:black"';} ?>>All</a>
									</div>
								</div>
								<div class="widget shop widget_swatches">
									<h4 class="widget-title"><span>Sizes</span></h4>
									<ul class="swatches-options clearfix">
										<li>
											<a title="Extra Large (3)" href="#" <?php if($size == 'XL'){echo 'style="background-color:black"';} ?> ukuran="XL" class="filter size">
												<img src="<?php echo $workdir ?>images/sizes/XL.jpg" alt="Extra Large" width="32" height="32"/>
											</a>
										</li>
										<li>
											<a title="Extra Extra Large (3)" href="#" <?php if($size == 'XXL'){echo 'style="background-color:black"';} ?> ukuran="XXL" class="filter size">
												<img src="<?php echo $workdir ?>images/sizes/XXL.jpg" alt="Extra Extra Large" width="32" height="32"/>
											</a>
										</li>
										<li>
											<a title="Large (3)" href="#" <?php if($size == 'L'){echo 'style="background-color:black"';} ?> ukuran="L" class="filter size">
												<img src="<?php echo $workdir ?>images/sizes/L.jpg" alt="Large" width="32" height="32"/>
											</a>
										</li>
										<li>
											<a title="Medium (3)" href="#" <?php if($size == 'M'){echo 'style="background-color:black"';} ?> ukuran="M" class="filter size">
												<img src="<?php echo $workdir ?>images/sizes/M.jpg" alt="Medium" width="32" height="32"/>
											</a>
										</li>
										<li>
											<a title="Small (3)" href="#" <?php if($size == 'S'){echo 'style="background-color:black"';} ?> ukuran="S" class="filter size">
												<img src="<?php echo $workdir ?>images/sizes/S.jpg" alt="Small" width="32" height="32"/>
											</a>
										</li>
									</ul>
								</div>
								<div class="widget shop widget_product_tag_cloud">
									<h4 class="widget-title"><span>Fit</span></h4>
									<div class="tagcloud">
										<a href="#" <?php if($fit == 'Slim'){echo 'style="border-color:black"';} ?> class="filter fit">Slim</a>
										<a href="#" <?php if($fit == 'Regular'){echo 'style="border-color:black"';} ?> class="filter fit">Regular</a>
									</div>
								</div>
								<!-- <div class="widget shop widget_product_categories">
									<h4 class="widget-title"><span>Categories</span></h4>
									<ul class="product-categories">
										<?php 
										if($product_category){ foreach ($product_category as $key_category => $value_category) {
											echo'<li><a href="#" class="filter category" id="'.$value_category['urlpage'].'">'.$value_category['title'].'</a></li>';
										}}?>
									</ul>
								</div> -->
								<div class="widget shop widget_products">
									<h4 class="widget-title"><span>Best Sellers</span></h4>
									<ul class="product_list_widget">
										<?php 
										if($product){ foreach ($product['row'] as $key => $value) {if($value['best_seller'] == 1){
											$discount_percent 	= $value['discount_percent'];
											$discount_value 	= ($value['price_normal']*$discount_percent)/100;
											$sale_price			= $value['price_normal']-$discount_value;
											echo'
											<li>
												<a href="/'.$curr_lang.'/product-detail/'.$value['urlpage'].'" title="Donec tincidunt justo">
													<img width="100" height="150" src="'.$workdir.'uploads/'.$value['product_image'].'" alt="Product-13"/> 
													<span class="product-title">'.$value['name'].'</span>
												</a>';
												if($value['sale_status'] == 1){
												echo'<del><span class="amount">IDR '.number_format($value['price_normal']).'</span></del>'; 
												echo'<ins><span class="amount"> IDR '.number_format($sale_price).'</span></ins>';
												}else{
												echo'<ins><span class="amount">IDR '.number_format($value['price_normal']).'</span></ins>'; 
												}
												echo'
											</li>';
										}}}?>
									</ul>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("foot.php"); ?>
			<script type='text/javascript' src='<?php echo $workdir ?>js/product.js'></script>
		</div>
		
		<?php include("modal.php"); ?>
		<?php include("footer.php"); ?>
</body>
</html>