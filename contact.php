<?php include("header.php"); ?>
	</head>
	
	<body>
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
            <div class="flexible-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7422054673348!2d106.83268331517932!3d-6.1652679955363965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5c5fab6dab1%3A0xfdffebf00e3033a!2sJl.+Pasar+Baru+Selatan+No.1%2C+Sawah+Besar%2C+Kota+Jakarta+Pusat%2C+Daerah+Khusus+Ibukota+Jakarta+10710!5e0!3m2!1sen!2sid!4v1452569620996" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div><!-- .flexible-map -->
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb f-g6">
							<li><span><a href="#" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span><?php echo $language_config[9]['lang_'.$curr_lang] ?></span></li>
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
										<div class="col-sm-8">
											<div class="row contact-form-wrapper">
												<div class="col-sm-12">
													<div class="title">
														<h2><?php echo $language_config[45]['lang_'.$curr_lang] ?></h2>
													</div>
													<?php 
													$cryptinstall="js/crypt/cryptographp.fct.php";
													include $cryptinstall;
													?>
													<form method="POST" action="/<?php echo $curr_lang ?>/contact_us" id="contact_us">
														<div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[41]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap your-name">
															    		<input type="text" name="name" value="" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[33]['lang_'.$curr_lang] ?><br />
														    		<p class="form-control-wrap your-email">
														    			<input type="email" name="email" value="" size="40" class="form-control text email validates-as-required validates-as-email" />
														    		</p>
														    	</div>
															</div>
															<div class="col-sm-12">
																<div><?php echo $language_config[42]['lang_'.$curr_lang] ?><br />
														    		<p class="form-control-wrap message">	<textarea name="message" cols="40" rows	="10" class="form-control textarea"></textarea>
														    		</p>
														    	</div>
															</div>
                                                            <div class="col-sm-6">
																<div><?php echo $language_config[43]['lang_'.$curr_lang] ?><br />
															    	<p class="form-control-wrap your-captcha">
															    		<input type="text" name="captcha" value="" size="40" class="form-control text validates-as-required" />
															    	</p>
															    </div>
															</div>
                                                            <div class="col-sm-6">
																<div><br>
                                                                	<div class="captcha-wrap">
                                                                    	<?php dsp_crypt(0,1) ?>
                                                                    </div><!-- .captcha-wrap -->
															    </div>
															</div>
														</div>
                                                        <br>
														<input type="submit" name="submit" value="<?php echo $language_config[44]['lang_'.$curr_lang] ?>" class="form-control submit f-g8" style="margin-bottom:20px;" />
													</form>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="row contact-info">
												<div class="col-sm-12">
													<div class="title">
														<h4><?php echo $language_config[32]['lang_'.$curr_lang] ?></h4>
													</div>
													<div class="separator content_element separator_align_center sep_width_100 sep_pos_align_center separator_no_text">
														<span class="sep_holder sep_holder_l">
															<span class="sep_line"></span>
														</span>
														<span class="sep_holder sep_holder_r">
															<span class="sep_line"></span>
														</span>
													</div>
													<div class="content_element">
														<div class="support-icon">
															<i class="fa fa-map-marker"></i>
															1 Pasar Baru Selatan, Jakarta Pusat 10710, Indonesia
														</div>
														<div class="support-icon">
															<i class="fa fa-phone"></i>
															+6221 345 7403
														</div>
                                                        <div class="support-icon">
															<i class="fa fa-fax"></i>
															+6221 385 8250
														</div>
														<div class="support-icon">
															<i class="fa fa-envelope-o"></i>
															<a href="mailto:info@klassiqueuniform.com">info@klassiqueuniform.com</a>
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