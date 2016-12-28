<?php 
require('../config/nuke_library.php');
require('../config/directory_config.php');
require "../config/Facebook/autoload.php";

@session_start();
$fb = new Facebook\Facebook([
	'app_id' => '790449017753773',
	'app_secret' => '8bd88b3229da02600595ae9d8af025d2',
	'default_graph_version' => 'v2.5',
	]);

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if (! isset($accessToken)) {
	if ($helper->getError()) {
		header('HTTP/1.0 401 Unauthorized');
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
	} else {
		header('HTTP/1.0 400 Bad Request');
		echo 'Bad request';
	}
	exit;
}

// Logged in
#echo '<h3>Access Token</h3>';
#var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
#echo '<h3>Metadata</h3>';
#var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('790449017753773');
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
	// Exchanges a short-lived access token for a long-lived one
	try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
		//exit;
	}

	echo '<h3>Long-lived</h3>';
	var_dump($accessToken->getValue());
}

try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/me?fields=id,first_name,last_name,gender,link,name,email,bio,birthday,work', $accessToken->getValue());
	# liat disini https://developers.facebook.com/docs/graph-api/reference/user/
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

$user = $response->getGraphUser();

$fetch_fb_id          = '';
$fetch_fb_first_name  = '';
$fetch_fb_last_name   = '';
$fetch_fb_email       = '';
$fetch_fb_gender 			= '';
$fetch_fb_link        = '';
$fetch_fb_birthday    = '';

if(isset($user['id'])){  $fetch_fb_id    = $user['id'];}
if(isset($user['first_name'])){	$fetch_fb_first_name 		= $user['first_name'];}
if(isset($user['last_name'])){	$fetch_fb_last_name 		= $user['last_name'];}
if(isset($user['email'])){	$fetch_fb_email 			= $user['email'];}
if(isset($user['gender'])){	$fetch_fb_gender 			= $user['gender'];}
if(isset($user['link'])){	$fetch_fb_link 				= $user['link'];}
if($user['birthday']){	$fetch_fb_birthday 			= date_format($user['birthday'], "Y-m-d");}


$cek_login = global_select_single("member","*","email = '$fetch_fb_email'");

if($cek_login){ #jika data emailnya sudah ada

	if($cek_login['email'] == $fetch_fb_email OR $cek_login['id_facebook'] == $fetch_fb_id){ #login
		$_SESSION['token_login'] = $cek_login['token'];
		log_activity('[<strong>LOGIN FROM FACEBOOK</strong>] [SUCESS] | idmember = '.$cek_login['id'].' | id_facebook = '.$cek_login['id_facebook'].' | fullname ='.$cek_login['fullname'].' | email = '.$cek_login['email']);
		redirect('/'.$curr_lang.'/edit-profile');
	}else{
		die("id facebook not match");
	}

}else{ # register
	$arr_data['id_facebook'] = $fetch_fb_id;
	$arr_data['token'] = create_token();
	$arr_data['fullname'] = $fetch_fb_first_name.' '.$fetch_fb_last_name;
	$arr_data['email']    = $fetch_fb_email;
	$arr_data['birth_date'] = $fetch_fb_birthday;
	$arr_data['gender']   = $fetch_fb_gender;
	$arr_data['status']   = 'Active';

	$query_register = global_insert('member',$arr_data);
	
	if($query_register){
		/*Add Log  BERHASIL REGISTER */ 
		$data_member = global_select_single("member","*","id = $query_register");
		$_SESSION['token_login'] = $data_member['token'];
		log_activity('[<strong>REGISTRATION</strong>] [SUCESS] | idmember = '.$query_register.' | fullname ='.$arr_data['fullname'].' | email = '.$arr_data['email']);
		redirect('/'.$curr_lang.'/change-password');
		die("Done. tinggal set redirect");
	}else{
		/*Add Log GAGAL*/
		log_activity('[<strong>REGISTRATION</strong>] [FAILED] | fullname ='.$clean['fullname'].' | email = '.$clean['email']);
		redirect('/'.$curr_lang.'/index');
		die("Gagal. Error save");
	}
}
?>