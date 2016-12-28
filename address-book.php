<?php 
@session_start();
include("header.php");
$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING);	}
cek_valid_session($token_login);

$member_login = global_select_single("member","*","token = '".$_SESSION['token_login']."'");
$address_book = global_select("member_addressbook","*","id_member = ".$member_login['id']);

/*custom mod untuk sweetalert tanpa session stat*/
$notify 	= global_select_single("alert_notify","*","`for` = 'sebelum_delete_addressbook'");
$yes 		= global_select_single("alert_notify","*","`for` = 'tombol_konfirmasi_hapus_yes'");
$no 		= global_select_single("alert_notify","*","`for` = 'tombol_konfirmasi_hapus_no'");
$sucess 	= global_select_single("alert_notify","*","`for` = 'sukses_hapus_addressbook'");
$fail 		= global_select_single("alert_notify","*","`for` = 'gagal_hapus_addressbook'");
$cancel 	= global_select_single("alert_notify","*","`for` = 'cancel_hapus_addressbook'");
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
							<li><span><?php echo $language_config[64]['lang_'.$curr_lang] ?></span></li>
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
													<li><a href="/<?php echo $curr_lang ?>/change-password"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[46]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/address-book" class="active"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[64]['lang_'.$curr_lang] ?></a></li>
													<li><a href="/<?php echo $curr_lang ?>/order-history"><i class="fa fa-chevron-right" style="margin-right:5px;"></i><?php echo $language_config[65]['lang_'.$curr_lang] ?></a></li>
												</ul>
											</div>
										</div>
									</div>
									
									<div class="col-sm-9">
										<div class="wpb_wrapper">
											<div class="row inner">
												<div class="col-sm-12">
													<form>
														<div class="content_element title">
															<h1><?php echo $language_config[64]['lang_'.$curr_lang] ?></h1>
														</div>
														<a href="#" class="btn btn-danger f-g8" role="button" data-rel="addAddressModal"><?php echo $language_config[76]['lang_'.$curr_lang] ?></a>
														<div class="row" style="margin-top:10px;">
															<div class="col-sm-6">
																<?php
																if($address_book){ 
																	foreach ($address_book as $key => $value) {

																	echo'
																	<div class="address-child" id="record-'.$value['id'].'">
																		<strong class="f-g8">'.$value['receiver_name'].'</strong> ('.$value['phone_number'].')<br>
																		'.$value['address'].'
																		<br/>
																		<a href="" data-rel="editAddressModal" id="'.$value['id'].'"><strong>(Edit)</strong></a> - <a href="#" class="f-red hapus_ini" id="'.$value['id'].'"><strong>('.$language_config[75]['lang_'.$curr_lang].')</strong></a>
																	</div><!-- .address-child -->';
																	}
																}else{
																	echo "No Address";
																}
																?>
															</div>

														</div>
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
		<?php include("modal_addressbook.php"); ?>
		<?php include("modal.php"); ?>
		<?php include("footer.php"); ?>

<script>
	$(document).ready(function() {
		$("header").removeClass("header-absolute header-transparent");
		
		$( ".hapus_ini" ).click(function() {
			var id = this.id;
			swal({
				title: "<?php echo $notify['title_'.$curr_lang] ?>",
				text: "<?php echo $notify['description_'.$curr_lang] ?>",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: "<?php echo $yes['title_'.$curr_lang] ?>",
				cancelButtonText: "<?php echo $no['title_'.$curr_lang] ?>",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm){
			    if (isConfirm){
			    	$.post( "/web/ajax/delete_addressbook.php", { id: id}, function( data ) {
						if(data==1){
							swal("<?php echo $sucess['title_'.$curr_lang] ?>", "<?php echo $sucess['description_'.$curr_lang] ?>", "success");
							$("#record-"+id).fadeOut();	
						}else{
							swal("<?php echo $sucess['title_'.$curr_lang] ?>", "<?php echo $sucess['description_'.$curr_lang] ?>", "warning");	
						} 
					});
			    } else {
					swal("<?php echo $cancel['title_'.$curr_lang] ?>", "<?php echo $sucess['description_'.$curr_lang] ?>", "error");
			    }
			});
		});
	});
</script>
</body>
</html>