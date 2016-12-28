<?php 

/*Split Language*/
$curr_lang = '';
$curr_page = '';
$curr_urlpage = '';

$arrayName = array('id','en');
$arr_url = explode("/", $_SERVER['REQUEST_URI']);

if(!isset($arr_url[1])) { redirect("klassique/id/index"); }
if(! in_array($arr_url[1], array("id", "en")) )  { redirect("klassique/id/index"); }

$curr_lang 		= $arr_url[1];
$curr_page 		= $arr_url[2];

if(isset($arr_url[3])){	
	$curr_id 		= $arr_url[1];
	$curr_page 		= $arr_url[2].'/'.$arr_url[3];
}

$GLOBALS['curr_lang'] = $curr_lang;
$GLOBALS['curr_page'] = $curr_page;
$workdir = '/web/';

if($curr_lang == 'id'){
	$display_lang = "BAHASA INDONESIA";
}elseif ($curr_lang == 'en') {
	$display_lang = "ENGLISH";
}

$link_dir = '/'.$curr_lang.'';
?>