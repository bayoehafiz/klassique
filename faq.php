<?php 
include("header.php"); 
$faq_category = global_select("faq_category","*","publish = 1");
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
							<li><span>FAQ</span></li>
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
									<div class="col-sm-8">
										<div class="wpb_wrapper">
											
											<?php 
											if($faq_category){
												foreach ($faq_category as $key => $value) {
													$id_category = $value['id'];
													echo'
													<div class="row inner faq-wrapper">
														<div class="col-sm-12">
															<div class="content_element title">
																<h2>'.$value['name_'.$curr_lang].'</h2>
															</div>';

															$faq = global_select("faq","*","publish = 1 AND `id_category` = $id_category ");
															if($faq){
																foreach ($faq as $key2 => $value2) {
																	echo'
																	<div class="toggle toggle_default toggle_color_default">
																		<div class="toggle_title">
																			<h4>'.$value2['question_'.$curr_lang].'</h4>
																			<i class="toggle_icon"></i>
																		</div>
																		<div class="toggle_content">
																			<p>
																				'.$value2['answer_'.$curr_lang].'
																			</p>
																		</div>
															</div>';

																}
															}
															echo'
														</div>
													</div>';
												}
											}
											?>
										
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