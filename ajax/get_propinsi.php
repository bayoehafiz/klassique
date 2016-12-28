<?php
@session_start();
include("../config/connection.php");
function menu_page($idpge){	
	global $db;	$que=$db->query("SELECT `name`,`name_eng` FROM `label_menu` WHERE `id`='$idpge'");	
	$row = $que->fetch_assoc();    
	if($_SESSION['lang']=="eng"): 
		return $row['name_eng']; 
	else: 
		return $row['name']; 
	endif;
}	
$country = $_POST['country'];
echo'<option value="">- Pilih Provinsi -</option>';
$query = $db->query("SELECT DISTINCT(`propinsi`) FROM `ongkir` WHERE `country`='$country' ORDER BY `propinsi` ASC");
while($row = $query->fetch_assoc()):	
	echo '<option value="'.$row['propinsi'].'">'.ucwords($row['propinsi']).'</option>';
endwhile;	
?>