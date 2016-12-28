<?php 
include("header.php"); 
require "config/directory_config.php";
$token_login = 'false';
if(isset($_SESSION['token_login'])){$token_login = filter_var($_SESSION['token_login'],FILTER_SANITIZE_STRING);	}

//cek_valid_session($token_login);

$data_member = get_data_member_by_token_login($token_login);

if(!isset($_SESSION['token_shopcart'])){ redirect('/'.$curr_lang.'/product-list'); }

/*UPDATE ID MEMBER DENGAN TOKEN CHART YG ADA*/
$db->query("UPDATE `shopcart_header` SET `id_member` = $data_member[id] WHERE `token` = '$_SESSION[token_shopcart]'");

$alert = global_select_single("alert_notify","*","`for` = 'harus_login_untuk_checkout'");

?>
	</head>
	<script type="text/javascript">
		$( "#quantity_number" ).click(function() {
		  	alert( "Handler for .change() called." );
		});
	</script>
	<body class="shop-account">
		<?php include("mobile-menu.php"); ?>
		<div id="wrapper" class="wide-wrap">
			<div class="offcanvas-overlay"></div>
			<?php include("head.php"); ?>
			<div class="heading-container">
				<div class="container heading-standar">
					<div class="page-breadcrumb">
						<ul class="breadcrumb">
							<li><span><a href="/<?php echo $curr_lang ?>/index" class="home"><span><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></span></li>
							<li><span>Cart</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="content-container">
				<div class="container">
					<div class="row">
						<div class="col-md-12 main-wrap">
							<div class="main-content">
								<div class="shop">
									<span style="visibility: hidden" id="swal_title"><?php echo $alert['title_'.$curr_lang] ?></span>
									<span style="visibility: hidden" id="swal_desc"><?php echo $alert['description_'.$curr_lang] ?></span>
									<div class="checkout-navigation f-g6">
										<div class="cn-cart active f-g8"><span>Cart</span></div>
										<div class="cn-checkout"><span>Checkout</span></div>
										<div class="cn-done"><span>Done</span></div>
									</div><!-- .checkout-navigation -->
									<?php table_item($_SESSION['token_shopcart'],$curr_lang); ?>
											
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