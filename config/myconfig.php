<?php


$SITE_NAME 			= "Klassique";


$SITE_URL  			= "http://klassique.colorblindlabs.com/";


$HOME_URL  			= $SITE_URL."index";


$WEBSITE_NAME 		= "Test 123"; //add by RNT 27 nov 15





/** APA BILA ADA PERGANTIAN NAMA FOLDER, HARAP DI PERHATIKAN, NAMA FOLDER SECARA FISIK dan HTACCESS nya **/


$ADMIN_URL  		= $SITE_URL."admin/";


$ADMIN_HOME  		= $ADMIN_URL."user-change-password.php";


$ADMIN_LOGIN  		= $ADMIN_URL."index.php";





$TABLE_PREFIX 		= ""; //PREFIX BELUM SEMPURNA //"amw1_";


$UPLOAD_FOLDER 		= $SITE_URL."uploads/";





$SITE_TOKEN			= sha1(preg_replace("/[^a-zA-Z]+/", "", $SITE_URL));


date_default_timezone_set('Asia/Jakarta');


?>
