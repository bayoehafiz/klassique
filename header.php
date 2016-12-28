<?php 
@session_start();
//error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');
require 'config/nuke_library.php';
require "config/directory_config.php";
require "config/webconfig-parameters.php";
require "config/language_config.php";
//require "config/Facebook/autoload.php";
//require "config/facebook_config.php";
require "shop/shopcart-table.php";


/*
//$whitelist = array('103.244.206.109', '117.112.117.119', '117.112.117.120', '117.102.113.10', '39.251.36.110');
$ipaddress = $_SERVER['REMOTE_ADDR'];
if($ipaddress == '103.244.206.109' || $ipaddress == '117.112.117.120' || $ipaddress == '117.102.113.10' || $ipaddress == '39.251.36.110' || $ipaddress == '180.242.210.11') {
    //Action for allowed IP Addresses
} else {
    //Action for all other IP Addresses
    echo 'You are not authorized here.'; 
    echo "<br />IP Address: ".$_SERVER['REMOTE_ADDR'];
    die();
}
*/




if(isset($_SERVER['REQUEST_URI'])):
	$server_uri = $_SERVER['REQUEST_URI'];
	$base_link = explode('/',$server_uri);
endif;	


function seo_page($id){
    global $db;

    $quip = $db->query("SELECT * FROM `seo` WHERE `id`='$id'");
    $res = $quip->fetch_assoc();
    return array('seo_title'=>$res['seo_title'], 'seo_keyword'=>$res['seo_keyword'], 'seo_description'=>$res['seo_description']);
}
	if($base_link[2] == 'index'){
		$idseo = 1;
	}elseif ($base_link[2] == 'about') {
		$idseo = 2;
	}elseif ($base_link[2] == 'news' OR $base_link[2] == 'news-detail') {
		$idseo = 3;
	}elseif ($base_link[2] == 'contact' OR $base_link[2] == 'faq' OR $base_link[2] == 'testimonial' OR $base_link[2] == 'contact' OR $base_link[2] == 'how-to-buy' OR $base_link[2] == 'custom-order' OR $base_link[2] == 'measurement-guide' OR $base_link[2] == 'return-policy' OR $base_link[2] == 'privacy-policy' OR $base_link[2] == 'terms-and-conditions') {
		$idseo = 4;
	}elseif ($base_link[2] == 'product-list') {
		$idseo = 5;
	}elseif ($base_link[2] == 'product-detail') {
		$idseo = 5;
	}else{
		$idseo = 1;
	}

	if(isset($idseo)){
		$seoitem			= seo_page($idseo);
		$seo_title 			= $seoitem['seo_title'];  
		$seo_keyword 		= $seoitem['seo_keyword']; 
		$seo_description 	= $seoitem['seo_description'];
	}
	$og_image = 'http://http://klassiqueuniform.com/images/klassique/klassique-logo.png';
	if($base_link[2] == 'product-detail'){
		$url_page 			= $base_link[3];
		$data_product 		= global_select_single("product","*","urlpage = '".$url_page."'");
		$seo_title 			= $data_product['seo_title'];  
		$seo_keyword 		= $data_product['seo_keyword']; 
		$seo_description 	= strip_tags($data_product['seo_description']);
		$og_image		 	= 'http://http://klassiqueuniform.com/web/uploads/'.$data_product['product_image'];
	}if($base_link[2] == 'news-detail'){
		$url_page 			= $base_link[3];
		$data_news 			= global_select_single("news","*","urlpage = '".$url_page."'");
		$seo_title 			= $data_news['seo_title'];  
		$seo_keyword 		= $data_news['seo_keyword']; 
		$seo_description 	= strip_tags($data_news['seo_description']);
		$og_image		 	= 'http://http://klassiqueuniform.com/web/uploads/'.$data_news['image_thumbnail'];
	}

$config = global_select_single("web_config","*");
$title = $config['name'];
?>

<!doctype html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<meta name="keywords" content="<?php echo $seo_keyword ?>">
<meta name="description" content="<?php echo $seo_description ?>">
<meta name="robots" content="all,index,follow">
<meta name="googlebot" content="all,index,follow">
<meta name="revisit-after" content="2 days">
<meta name="author" content="">
<meta name="rating" content="general">
<meta property="og:title" content="<?php echo $seo_title ?>">
<meta property="og:image" content="<?php echo $og_image ?>">
<meta property="og:site_name" content="Klassique Uniform">
<meta property="og:description" content="<?php echo $seo_description ?>">
<meta property="og:url" content="">
<title><?php echo $seo_title ?> | <?php echo $title ?></title>
<link rel="shortcut icon" href="<?php echo $workdir ?>images/favicon.ico">

<link rel='stylesheet' href='<?php echo $workdir; ?>css/settings.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo $workdir; ?>css/swatches-and-photos.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php echo $workdir; ?>css/font-awesome.min.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php echo $workdir; ?>css/google_fonts.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php echo $workdir; ?>css/elegant-icon.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo $workdir; ?>css/gentleman.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo $workdir; ?>css/style.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php echo $workdir; ?>css/shop.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?php echo $workdir; ?>css/layout.css' type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?php echo $workdir; ?>js/raty/jquery.raty.css" media="all" />
<link rel='stylesheet' href='<?php echo $workdir; ?>css/klassique.css' type='text/css' media='all'/>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery-1.11.3.min.js'></script>
<!-- SWAL -->
<link rel='stylesheet' href='<?php echo $workdir; ?>js/sweetalert/sweetalert.css' type='text/css' media='all'/>
<script type='text/javascript' src='<?php echo $workdir ?>js/sweetalert/sweetalert-dev.js'></script>
<script type="text/javascript">
	/*window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
	$.src="//v2.zopim.com/?3Nyz33yVOkHmHMIAd3vMme3ADwiDwCSl";z.t=+new Date;$.
	type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");*/
</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=790449017753773";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php require "config/stat.php"; ?>