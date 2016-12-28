<?php
	@session_start();
	require("../../config/connection.php");
	require("../../config/myconfig.php");
	require("function.php");
	require("webconfig-parameters.php");
	
	function replacehape($nomerhape){
		$jumlahkata = strlen($nomerhape);
		$kodearea = "62";
		$nohapebarulist = substr($nomerhape,1,$jumlahkata);
		return $kodearea.$nohapebarulist;
	}

	//user admin
	$useradminid = $_SESSION[$SITE_TOKEN.'userID'];
	//save order
	date_default_timezone_set('Asia/Jakarta');
	$dateNow = date("d-m-Y H:i:s");
												
	$idorder = $_GET['idorder'];
	$que = $db->query("SELECT * FROM `order_header` WHERE `id`='$idorder' ");
	$row = $que->fetch_assoc();
	
	$ordidmm = $row['id'];
	$idmembernew = $row['idmember'];
	$tokenordernew = $row['tokenpay'];
	$totalamount = ( ( $row['orderamount']+$row['shippingcost'] ) - $row['discountamount'] ) + $row['kode_unik'];
	if($row['phone_penerima']<>''): $Phonelabel = '('.$row['phone_penerima'].')'; else: $Phonelabel = ''; endif;
	
	//select member
	$query = $db->query("SELECT * FROM `member` WHERE `id`='$idmembernew'");
	$res = $query->fetch_assoc();
	$member_name = $res['fullname'];
	$emailmembername = $res['email'];
	$nomerhape_member = replacehape($res['handphone']);	
	
	if($row['status_payment'] <> "Confirmed"):
		$quipst3 = $db->query("UPDATE `order_header` SET `status_payment`='Confirmed', `konfirmasi_bayar_byadmin`='$useradminid', `tanggal_konfirmasi`='$dateNow' WHERE `id`='$ordidmm'");	
	endif;	
	
	require("email_orderan/confirm-payment-email-order.php");		 
			 	
	echo'<script language="JavaScript">';
		echo'window.location="../ordermember.php?msg=Confrim successful.";';
	echo'</script>';
?>