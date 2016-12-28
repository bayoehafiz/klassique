<?php 
include("header.php"); 

$urlpage = filter_var($_GET['urlpage'],FILTER_SANITIZE_STRING);

cek_valid_url_news_detail($urlpage);

$id_news =  get_id_from_urlpage($urlpage,'news');

$news = global_select_single("news","*","id = $id_news");
$next = select_custom("select `id`,`urlpage`,`title` from `news` where id = (select min(id) from `news` where id > $id_news)");
$prev = select_custom("select `id`,`urlpage`,`title` from `news` where id = (select max(id) from `news` where id < $id_news)");

$other = global_select("news","*","id != $id_news");
?>
	</head>
	
	<script type="text/javascript">
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

	<body>
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb f-g6">
							<li><span><a href="/<?php echo $curr_lang ?>/index" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span><a href="/<?php echo $curr_lang ?>/news"><span><?php echo $language_config[40]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span><?php echo $news['title'] ?></span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-md-9 main-wrap">
							<div class="main-content">
								<article class="hentry">
									<div class="hentry-wrap">
										<div class="entry-featured">
											<img width="800" height="800" src="<?php echo $workdir ?>images/blog/blog-9.jpg" alt="blog-9"/>
										</div>
										<div class="entry-header">
											<h1 class="entry-title"><?php echo $news['title'] ?></h1>
											<div class="entry-meta icon-meta">
												<span class="meta-date">
													<time datetime="2015-08-11T06:27:22+00:00">
														<i class="fa fa-clock-o"></i>August 11, 2015
													</time>
												</span>
											</div>
										</div>
										<div class="entry-content">
											<?php echo $news['description'] ?>
										</div>
										<div class="entry-footer">
											<div class="row">
												<div class="col-sm-6">
													<div class="entry-tags">
														<a href="#">Lacus</a><a href="#">Praesent</a>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="share-links">
														<div class="share-icons">
															<span class="facebook-share">
																<a href="javascript:fbShare('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>',520, 350)" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
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
								</article>
								<nav class="post-navigation">
									<div class="row">

										<div class="col-sm-6">
											<div class="prev-post">
												<?php if($prev){ ?>
												<span>Previous article </span>
												<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $prev['row'][0]['urlpage'] ?>"><?php echo $prev['row'][0]['title'] ?></a>
												<?php }?>
											</div>
										</div>										
										<div class="col-sm-6">
											<div class="next-post">
												<?php if($next){ ?>
												<span>Next article </span>
												<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $next['row'][0]['urlpage'] ?>"><?php echo $next['row'][0]['title'] ?></a>
												<?php } ?>
											</div>
										</div>

									</div>
								</nav>
								
							</div>
						</div>
						<div class="col-md-3 sidebar-wrap">
							<div class="main-sidebar">
								<div class="widget widget-post-thumbnail">
									<h4 class="widget-title"><span><?php echo $language_config[31]['lang_'.$curr_lang] ?></span></h4>
									<ul class="posts-thumbnail-list">
										<?php if($other){
											foreach ($other as $key => $value) {?>
												<li>
													<div class="posts-thumbnail-image">
														<a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>">
															<img width="600" height="450" src="<?php echo $workdir ?>uploads/<?php echo $value['image_thumbnail'] ?>" alt="blog-2"/>
														</a>
													</div>
													<div class="posts-thumbnail-content">
														<h4><a href="/<?php echo $curr_lang ?>/news-detail/<?php echo $value['urlpage'] ?>"><?php echo $value['title'] ?></a></h4>
													</div>
												</li>
												<?php
											}
										 }?> 
									</ul>
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
	});
</script>
</body>
</html>