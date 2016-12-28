<?php 


if(!isset($db)){


	$host			= 'localhost';


	$dbUsername		= 'klassiq1_2016';


	$dbPassword		= 'Lov=gwO17uXy';


	$dbName			= 'klassiq1_2016';





	$db = new mysqli($host, $dbUsername, $dbPassword, $dbName);


	if($db->connect_errno){


		die("We're Sorry. We are under Maintenance within 3 hours. Thank You");


		exit();


	}


}


?>