<?php 	
	 @session_start();
	 include('config/connection.php');
	 //include "include/function.php";
	 include "config/myconfig.php";

	  function cancelorderlistmember($orderid){		
			global $db;
			$que = $db->query("SELECT `id`,`tokenpay` FROM `order_header` WHERE `id`='$orderid' and `status_payment`='Pending On Payment' ");
			$jumpage = $que->num_rows;
			if($jumpage>0):
				$row = $que->fetch_assoc();
				$ordidmm = $row['id'];
				
				$quipst3 = $db->query("UPDATE `order_header` SET `status_payment`='Transaction Fail', `status_delivery`='Transaction Fail' WHERE `id`='$orderid' ");
			
				$idprod = ''; $totalqty = 0; 
				$que33 = $db->query("SELECT `iddetail`,`qty` FROM `order_detail` WHERE `tokenpay`='".$row['tokenpay']."' ORDER BY `id` ASC");
				while($data = $que33->fetch_assoc()):
					$iddetail = $data['iddetail'];
					$totalqty = $data['qty'];
					$quipst2 = $db->query("UPDATE `product_detail_size` SET `stock` = `stock`+'$totalqty' WHERE `id`='$iddetail'");	
				endwhile;	
			endif;			
		}	
	 
		//VERITRANS NOTIFICATION.
		include_once('veritrans/veritrans-php-master/Veritrans.php');
		Veritrans_Config::$serverKey = "VT-server-QWHK4WW2UCIZgiK7EEQaST5e";
						
		$notif = new Veritrans_Notification();
		$transaction = $notif->transaction_status;
		$fraud = $notif->fraud_status;
		
		$order_id = (int) $notif->order_id; 
		$order_idLIST = sprintf('%01d',$order_id);
		
		echo 'Order ID. '.$order_idLIST;
		echo '<br />Status. '.$transaction;
		echo '<br />Status Detail. '.$fraud;
		
		if ( strtolower($transaction) == 'capture') {
				if (strtolower($fraud) == 'challenge') {
					 // TODO Set payment status in merchant's database to 'challenge'
					 $arr_update = array("status_payment" => "challenge");
					 $que = $db->query("UPDATE `order_header` SET `status_payment`='Waiting' WHERE `id`='$order_idLIST' ");
				}
				else if (strtolower($fraud) == 'accept') {
					 // TODO Set payment status in merchant's database to 'success'
					$arr_update = array("status_payment" => "approve");
					 $que = $db->query("UPDATE `order_header` SET `status_payment`='Confirmed' WHERE `id`='$order_idLIST' ");
				}else{
					 $que = $db->query("UPDATE `order_header` SET `status_payment`='Waiting' WHERE `id`='$order_idLIST' ");
				}

		}else if (strtolower($transaction) == 'settlement') {
				
				$que = $db->query("UPDATE `order_header` SET `status_payment`='Waiting' WHERE `id`='$order_idLIST' ");
								
		}else if (strtolower($transaction) == 'cancel') {
				if (strtolower($fraud) == 'challenge') {
				  // TODO Set payment status in merchant's database to 'failure'
				  $arr_update = array("status_payment" => "failed");
				  cancelorderlistmember($order_idLIST);          
				}
				else if (strtolower($fraud) == 'accept') {
				  // TODO Set payment status in merchant's database to 'failure'
				   $arr_update = array("status_payment" => "failed");
				   cancelorderlistmember($order_idLIST);   
				}
		
		
		}else if (strtolower($transaction) == 'deny') {
		  // TODO Set payment status in merchant's database to 'failure'
			 $arr_update = array("status_payment" => "deny");
			 cancelorderlistmember($order_idLIST);
		}
?>