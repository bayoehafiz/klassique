<?php 
$fb = new Facebook\Facebook([
  'app_id' => '790449017753773',
  'app_secret' => '8bd88b3229da02600595ae9d8af025d2',
  'default_graph_version' => 'v2.5',
  ]);

$helper = $fb->getRedirectLoginHelper("http://klassiqueuniform.com//".$curr_lang."/login-facebook");

$permissions = ['email','user_about_me','user_birthday'];
$loginUrl = $helper->getLoginUrl('http://klassiqueuniform.com//'.$curr_lang.'/login-facebook', $permissions);
?>