<?php 
@session_start();
require('../config/nuke_library.php');
require('../config/directory_config.php');

unset($_SESSION['token_login']);
$_SESSION['stat'] = 'member_logout';
echo'<script type="text/javascript">window.location="/'.$curr_lang.'/index"</script>';

?>