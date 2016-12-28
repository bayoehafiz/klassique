<?php 
include("header.php"); 
$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING);	}
cek_valid_session($token_login);
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
                                                    <li><a href="/<?php echo $curr_lang ?>/change-password" class="active"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[46]['lang_'.$curr_lang] ?></a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/address-book"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[64]['lang_'.$curr_lang] ?></a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/order-history"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[65]['lang_'.$curr_lang] ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
									</div>
                                    
									<div class="col-sm-9">
										<div class="wpb_wrapper">
											<div class="row inner">
												<div class="col-sm-12">
                                                	<form method="POST" action="/<?php echo $curr_lang ?>/member-change-password" id="member_change_password">
                                                        <div class="content_element title">
                                                            <h1><?php echo $language_config[46]['lang_'.$curr_lang] ?></h1>
                                                        </div>
                                                        <div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[48]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap old-pass">
															    		<input type="password" name="password1" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
														</div>
                                                        <div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[49]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap new-pass">
															    		<input type="password" name="password2" id="password2" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
                                                            <div class="col-sm-6">
																<div><?php echo $language_config[50]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap new-pass2">
															    		<input type="password" name="password3" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
														</div>
                                                        <input type="submit" name="submit" value="<?php echo $language_config[51]['lang_'.$curr_lang] ?>" class="form-control submit f-g8" style="margin-bottom:20px;" />
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