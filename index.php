<?php 
include("header.php"); 
$slider 	= global_select("slider","*","publish = 1");
$highlight 	= global_select("product_highlight","*","publish = 1");
?>
	</head>

	<body>
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="content-container no-padding">
				<div class="container-full">
					<div class="row">
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div id="home-slider" data-autorun="yes" data-duration="6000" class="carousel slide fade dhslider dhslider-custom " data-height="650">
									<div class="dhslider-loader">
										<div class="fade-loading">
											<i></i><i></i><i></i><i></i>
										</div>
									</div>
									<div class="carousel-inner dhslider-wrap">
										<?php 
										if($slider){
											$counter = 1;
											foreach ($slider as $key => $value) {
												if($counter == 1){
													$align = "left";
													$active = "active";
												}else{
													$align = "right";
													$active = "";
												}
												?>
												<div class="item slider-item <?php echo $active ?>">
													<div class="slide-bg slide-bg-<?php echo $counter;?>" style="background-image:url(<?php echo $workdir ?>uploads/<?php echo $value['banner_image'] ?>)"></div>  
													<div class="slider-caption caption-align-<?php echo $value['text_position'] ?>">
														<div class="slider-caption-wrap">
															<span class="slider-top-caption-text"><?php echo $value['top_caption_text_'.$curr_lang] ?></span>
															<h2 class="slider-heading-text"><?php echo $value['heading_text_'.$curr_lang] ?></h2>
															<div class="slider-caption-text"><?php echo $value['bot_caption_text_'.$curr_lang] ?></div>
															<div class="slider-buttons">
																<a href="<?php echo $value['detail_link'] ?>" class="btn btn-lg btn-white-outline">Detail</a>
																<a href="<?php echo $value['buy_now_link'] ?>" class="btn btn-lg btn-white-outline">Buy Now</a>
															</div>
														</div>
													</div>
												</div>
												<?php
												$counter++;
											}
										}
										?>
									</div>
									<ol class="carousel-indicators parallax-content">
										<?php 
										if($slider){
											$counter = 0;
											foreach ($slider as $key => $value) {
												if($counter == 0){
													$class = 'class="active"';
												}else{
													$class = '';
												}
												?>
												<li data-target="#home-slider" data-slide-to="<?php echo $counter ?>" <?php echo $class ?>></li>
												<?php
												$counter++;
											}
										} ?>
									</ol>
								</div>
								<div class="product-categories-grid">
									<div class="product-categories-grid-wrap clearfix">
										<div class="product-category-wall">
										
											<?php 
											if($highlight){
												$counter = 1;
												foreach ($highlight as $key => $value) {
													if($counter == 1){
														$title = 'in';
													}else{
														$title = 'out';
													}
													?>
													<div class="wall-col col-md-6 col-sm-12 title-<?php echo $title ?> product-category-wall">
														<a href="<?php echo $value['link'] ?>">
															<div class="product-category-grid-item">
																<div class="product-category-grid-item-wrap">
																	<div class="product-category-grid-featured-wrap">
																		<div class="product-category-grid-featured bg-1" style="background-image:url(<?php echo $workdir ?>uploads/<?php echo $value['product_image'] ?>);"></div>
																		<span class="klassique-banner-mask"></span>
																	</div>
																	<div class="product-category-grid-featured-summary">
																		<h3 class="f-g8"><?php echo $value['name'] ?> <small class="f-g6"><?php echo $value['description_'.$curr_lang] ?></small></h3>
																	</div>
																</div>
															</div>
														</a>
													</div>
													<?php
													$counter++;
												}
											}
											?>
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
</body>
</html>