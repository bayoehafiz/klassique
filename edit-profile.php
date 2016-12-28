<?php 
include("header.php");

$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING);	}
cek_valid_session($token_login);
$from = '';
$data_member = get_data_member_by_token_login($_SESSION['token_login']);
if(isset($_GET['from'])){
	$from = filter_var($_GET['from'],FILTER_SANITIZE_STRING);
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
							<li><span><?php echo $language_config[52]['lang_'.$curr_lang] ?></span></li>
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
									<?php 
									if($from == 'checkout'){
										echo'<div style="width:100%;padding-botton:20px;text-align:center;background-color:rgba(255,204,0,0.65);padding:15px;">
											<p style="font-size:16px;font-weight:bold;">Please complete your billing address and shipping address before checkout</p>
											<p>Once you have completed it, you will be redirected automatically to checkout page</p>
										</div>
										<div style="clear:both;height:20px;"></div>';
									}
									?>
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
													<li><a href="/<?php echo $curr_lang ?>/edit-profile" class="active"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[52]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/change-password"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[46]['lang_'.$curr_lang] ?></a></li>
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
													<form method="POST" action="/<?php echo $curr_lang ?>/member-editdata" id="member_profile">
														<input type="hidden" name="from" value="<?php echo $from ?>">
														<div class="content_element title">
															<h1><?php echo $language_config[52]['lang_'.$curr_lang] ?></h1>
														</div>
														<div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[53]['lang_'.$curr_lang] ?><br />
																	<p class="form-control-wrap your-name">
																		<input type="text" name="fullname" value="<?php echo $data_member['fullname'] ?>" size="40" class="form-control text validates-as-required" />
																	</p>
																</div>
															</div>
															<div class="col-sm-6">
																<div>Email<br />
																	<p class="form-control-wrap your-email">
																		<input type="email" name="email" value="<?php echo $data_member['email'] ?>" size="40" class="form-control text email validates-as-required validates-as-email" />
																	</p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[56]['lang_'.$curr_lang] ?><br />
																	<p class="form-control-wrap your-phone">
																		<input type="text" name="phone" value="<?php echo $data_member['phone'] ?>" size="40" class="form-control text validates-as-required" />
																	</p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[55]['lang_'.$curr_lang] ?><br />
																	<p class="form-control-wrap your-mphone">
																		<input type="text" name="handphone" value="<?php echo $data_member['handphone'] ?>" size="40" class="form-control text validates-as-required" />
																	</p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[54]['lang_'.$curr_lang] ?><br />
																	<p><span class="form-flat-select" style="width:100%; display:block;">
																		<select style="width:100%" name="gender">
																			<option value="Men">Men</option>
																			<option value="Women">Woman</option>
																		</select>
																	</span></p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[57]['lang_'.$curr_lang] ?><br />
																	<p class="form-control-wrap your-bdate">
																		<input type="date" name="birth_date" value="<?php echo $data_member['birth_date'] ?>" size="40" class="form-control text validates-as-required" />
																	</p>
																</div>
															</div>
														</div>
														<h2><?php echo $language_config[58]['lang_'.$curr_lang] ?></h2>
														<div class="row">
															<div class="col-sm-6">
																<div><?php echo $language_config[59]['lang_'.$curr_lang] ?><br />
																	<p><span class="form-flat-select" style="width:100%; display:block;">
																		<select style="width:100%" id="country" name="country">
																			<option value="">- Pilih Country -</option>
																			<?php countrylist($data_member['country']); ?>
																		</select>
																	</span></p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[60]['lang_'.$curr_lang] ?><br />
																	<p><span class="form-flat-select" style="width:100%; display:block;">
																		<select style="width:100%" name="propinsi" id="propinsi">
																			<option value="">- Pilih Provinsi -</option>
																			<?php propinsilistedit($data_member['country'],$data_member['propinsi']);?>
																		</select>
																	</span></p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[61]['lang_'.$curr_lang] ?><br />
																	<p><span class="form-flat-select" style="width:100%; display:block;">
																		<select style="width:100%" id="kabupaten" name="kabupaten">
																			<option value="">- Pilih Kabupaten -</option>
																			<?php kabupatenlistedit($data_member['propinsi'],$data_member['kabupaten']);?>
																		</select>
																	</span></p>
																</div>
															</div>
															<div class="col-sm-6">
																<div><?php echo $language_config[62]['lang_'.$curr_lang] ?><br />
																	<p><span class="form-flat-select" style="width:100%; display:block;">
																		<select style="width:100%" id="namakota" name="idkota">
																			<option value="">- Pilih Kota -</option>
																			<?php kotalistedit($data_member['kabupaten'],$data_member['idkota']);?>
																		</select>
																	</span></p>
																</div>
															</div>
															<div class="col-sm-6">
																<div>Kode Pos<br />
																	<p class="form-control-wrap your-mphone">
																		<input type="text" name="kodepos" value="<?php echo $data_member['kodepos'] ?>" size="40" class="form-control text validates-as-required" />
																	</p>
																</div>
															</div>
															<div class="col-sm-12">
																<div>Alamat<br />
																	<p class="form-control-wrap your-message">	<textarea name="address" cols="40" rows="6" class="form-control textarea"><?php echo $data_member['address'] ?></textarea>
																	</p>
																</div>
															</div>
														</div>
														<input type="submit" name="submit" value="Update Profile" class="form-control submit f-g8" style="margin-bottom:20px;" />
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