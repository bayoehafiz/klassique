<?php
@session_start();
include("../config/connection.php");

$propinsi = $_POST['propinsi'];
echo'<option value="">- Pilih Kabupaten -</option>';
$query = $db->query("SELECT DISTINCT(`kabupaten`) FROM `ongkir` WHERE `propinsi`='$propinsi' ORDER BY `kabupaten` ASC");
while(
	$row = $query->fetch_assoc()):	
	echo '<option value="'.$row['kabupaten'].'">'.ucwords($row['kabupaten']).'</option>';endwhile;
?>