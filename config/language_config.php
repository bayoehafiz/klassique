<?php 
/*
	disini setiap language udah di siapin dalam array dan key nya adalah id nya
	jgn ganti nama var
*/

# language
$arr_mentah_language_config = global_select("language","`id`,`lang_id`,`lang_en`");
foreach ($arr_mentah_language_config as $key => $value) {
	$GLOBALS['language_config'][$value['id']] = $value; 
}

# pages
$arr_mentah_pages_config = global_select("pages","*");
foreach ($arr_mentah_pages_config as $key => $value) {
	$GLOBALS['pages_config'][$value['id']] = $value; 
}
?>