<?php 
include("header.php"); 
$help = global_select_single("help","*","id = 12");
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
							<li><span><?php echo $language_config[67]['lang_'.$curr_lang] ?></span></li>
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
                                                    <h4>Links</h4>
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
                                                	<li><a href="/<?php echo $curr_lang ?>/testimonial"><i class="fa fa-chevron-right" style="margin-right:5px;"></i>Testimonial</a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/how-to-buy"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[39]['lang_'.$curr_lang] ?></a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/custom-order"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[18]['lang_'.$curr_lang] ?></a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/measurement-guide" class="active"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[67]['lang_'.$curr_lang] ?></a></li>
                                                    <!-- <li><a href="/<?php echo $curr_lang ?>/return-policy"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[13]['lang_'.$curr_lang] ?></a></li> -->
                                                    <li><a href="/<?php echo $curr_lang ?>/privacy-policy"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[7]['lang_'.$curr_lang] ?></a></li>
                                                    <li><a href="/<?php echo $curr_lang ?>/terms-and-conditions"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[8]['lang_'.$curr_lang] ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
									</div>
                                    
									<div class="col-sm-9">
										<div class="wpb_wrapper">
											<div class="row inner">
												<div class="col-sm-12">
													<div class="content_element title">
														<h1>Measurement Guide</h1>
													</div>
                                                    
                                                    <div class="measure-child">
                                                    	<?php echo $help['text_'.$curr_lang] ?>
                                                    
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