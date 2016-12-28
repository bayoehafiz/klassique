<?php 
include("header.php"); 
$banner = global_select_single("aboutus_banner","*");
$data = global_select_single("aboutus","*");
$news = global_select("news","*,DATE_FORMAT(`date`,'%d %M %Y') as `tanggal`","publish = 1");
?>
	</head>
	
	<body>
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container heading-resize heading-no-button">
				<div class="heading-background heading-parallax bg-1" style="background-image:url(<?php echo $workdir ?>uploads/<?php echo $banner['image'] ?>)">
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
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 main-wrap">
							<div class="main-content">
								<article class="hentry">
									<div class="hentry-wrap">
										<div class="entry-header">
											<h1 class="entry-title"><?php echo $data['title_'.$curr_lang] ?></h1>
										</div>
										<div class="entry-content">
											<p>
												<a href="<?php echo $workdir ?>images/blog/blog-11.jpg">
													<img class="alignleft" src="<?php echo $workdir ?>uploads/<?php echo $data['image_content'] ?>" alt="" />
												</a>
											</p>
											<?php echo $data['description_'.$curr_lang] ?>
											
											<p>&nbsp;</p>
											<div class="readmore-link">
												<a href="<?php echo $workdir.'uploads/'.$data['file'] ?>" class="f-g6" download><i class="fa fa-download"></i>&nbsp;&nbsp;<?php echo $language_config[23]['lang_'.$curr_lang] ?></a>
											</div><!-- .readmore-link -->
										</div>
									</div>
								</article>
								<div class="related-post">
									<div class="related-post-title">
										<h3><span><?php echo $language_config[40]['lang_'.$curr_lang] ?></span></h3>
									</div>
									<div class="row related-post-items">
										
										<?php 
										if($news){
											foreach ($news as $key => $value) {?>
												<div class="related-post-item col-md-3 col-sm-6">
													<div class="entry-featured">
														<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>">
															<img width="800" height="800" src="<?php echo $workdir ?>images/blog/blog-1.jpg" alt="blog-1"/>
														</a>
													</div>
													<div class="entry-info">
														<div class="entry-header">
															<h4 class="post-title">
																<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>"><?php echo $value['title'] ?></a>
															</h4>
															<div class="entry-meta icon-meta">
																<span class="meta-date">
																	<time datetime="2015-08-11T06:27:49+00:00">
																		<i class="fa fa-clock-o"></i><?php echo $value['tanggal'] ?>
																	</time>
																</span>
															</div>
														</div>
														<div class="entry-content">
															<?php echo substr($value['description'],0,200).'...' ?>
														</div>
														<div class="readmore-link">
															<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>"><?php echo $language_config[22]['lang_'.$curr_lang] ?></a>
														</div>
													</div>
												</div>
												<?php 
											}
										}
										?>
									</div>
								</div>
							</div>
						</div><!-- .main-wrap -->
					</div>
				</div>
			</div>
			<?php include("foot.php"); ?>
		</div>
		<?php include("modal.php"); ?>
		<?php include("footer.php"); ?>
</body>
</html>