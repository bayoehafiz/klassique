<?php 
include("header.php"); 
/*Paging*/
if(isset($_GET['halaman'])){ $halaman = $_GET['halaman']; }else{ $halaman = 1; }
$jumlah_data 	= num_rows("news","*,DATE_FORMAT(`date`,'%d %M %Y') as `tanggal`","publish = 1");
$batas			=	1; // limit per page
$posisi			=	pagenum($halaman,$batas);

$banner = global_select_single("news_banner","*","publish = 1");
$news = global_select("news","*,DATE_FORMAT(`date`,'%d %M %Y') as `tanggal`","publish = 1","sortnumber ASC LIMIT $posisi,$batas");


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
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div class="row">
									<div class="col-sm-12">
										<div class="posts masonry" data-layout="masonry" data-masonry-column="3">
											<div class="posts-wrap masonry-wrap posts-layout-masonry row">
												
												<?php
												if($news){
													foreach ($news as $key => $value) {?>

														<article class="masonry-item col-md-4 col-sm-6 hentry">
															<div class="hentry-wrap">
																<div class="entry-featured">
																	<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>">
																		<img width="800" height="800" src="<?php echo $workdir ?>uploads/<?php echo $value['image_news'] ?>" alt="blog-12"/>
																	</a>
																</div>
																<div class="entry-info">
																	<div class="entry-header">
																		<h2 class="entry-title">
																			<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>"><?php echo $value['title'] ?></a>
																		</h2>
																		<div class="entry-meta icon-meta">
																			<span class="meta-date">
																				<time datetime="2015-08-11T06:27:49+00:00">
																					<i class="fa fa-clock-o"></i><?php echo $value['tanggal'] ?>
																				</time>
																			</span>
																		</div>
																	</div>
																	<div class="entry-content">
																		<?php echo substr($value['description'],0,180) ?>
																	</div>
																	<div class="readmore-link">
																		<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>"><?php echo $language_config[22]['lang_'.$curr_lang] ?></a>
																	</div>
																</div>
															</div>
														</article>
												
														<?php
													}
												}else{
													echo "No News Available";
												}
												?>
											</div>

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
													echo'<a class="next page-numbers" href="/'.$curr_lang.'/news/'.$previous.'">';
													echo'<i class="fa fa-angle-left"></i>';
												}else{
												}

												if($halaman==''){ $halaman=1; }else{ $halaman=$halaman; }
												for($y=$startpage;$y<=$limitpage;$y++){
													if($y!=$halaman){
														echo'<a class="page-numbers" href="/'.$curr_lang.'/news/'.$y.'">'.$y.'</a>';
													}else{
														echo'<span class="page-numbers current">'.$y.'</span>';
													}
												}

												// kalo halaman kecil. tombol next aktiv
												if($halaman < $jmlhalaman){
													$next=$halaman+1;
													echo'<a class="next page-numbers" href="/'.$curr_lang.'/news/'.$next.'">';
													echo'<i class="fa fa-angle-right"></i>';
												}else{
												}
												echo'</a>';
												echo'</div>';
												?>
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
</body>
</html>