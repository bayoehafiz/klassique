<?php 
include("header.php"); 
$token_reset = '';
if(isset($_GET['token_reset']) AND $_GET['token_reset'] != ''){
	$token_reset = filter_var($_GET['token_reset'],FILTER_SANITIZE_STRING);
}
$cek_valid = global_select_single("member","*","token_reset = '$token_reset'");
if(!$cek_valid){
	redirect('/'.$curr_lang.'/index');
}
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
							<li><span><?php echo $language_config[46]['lang_'.$curr_lang] ?></span></li>
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
									<div class="col-sm-9">
										<div class="wpb_wrapper">
											<div class="row inner">
												<div class="col-sm-12">
                                                	<form method="POST" action="/<?php echo $curr_lang ?>/restore_password">
                                                        <div class="content_element title">
                                                            <h1><?php echo $language_config[46]['lang_'.$curr_lang] ?></h1>
                                                        </div>
                                                        <div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[49]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap new-pass">
															    		<input type="password" name="new-pass" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
                                                            <div class="col-sm-6">
																<div><?php echo $language_config[50]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap new-pass2">
															    		<input type="password" name="new-pass2" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
														</div>
                                                        <input type="submit" value="<?php echo $language_config[51]['lang_'.$curr_lang] ?>" class="form-control submit f-g8" style="margin-bottom:20px;" />
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