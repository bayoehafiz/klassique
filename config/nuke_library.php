<?php 
include('myconfig.php');
include('connection.php');

$_GET = form_clean($_GET);
$_POST = form_clean($_POST);

function cek_valid_session($token_login){
    global $db;
    $validasi = 'Tidak Valid';
    $query = $db->query("SELECT * FROM `member` WHERE `token` = '$token_login'");

    if($query){
        $jumlah_data = $query->num_rows;
        if($jumlah_data == 1){
            $validasi = "valid";
        }
        if($validasi != 'valid'){ echo'<script type="text/javascript">window.location="/"</script>'; die(); }
    }else{
        echo'<script type="text/javascript">window.location="/"</script>'; die();
    }
}

function encode_image($path){
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function cek_valid_session_for_checkout($token_login){
    global $db;
    $validasi = 'Tidak Valid';
    $query = $db->query("SELECT * FROM `member` WHERE `token` = '$token_login'");

    if($query){
        $jumlah_data = $query->num_rows;
        if($jumlah_data == 1){
            $validasi = "valid";
        }
        if($validasi != 'valid'){ $_SESSION['stat'] = 'harus_login_untuk_checkout'; echo'<script type="text/javascript">window.location="/id/cart"</script>'; die(); }
    }else{
        echo'<script type="text/javascript">window.location="/id/cart"</script>'; die();
    }
}

function cek_valid_url_news_detail($url){
    global $db;
    $validasi = 'Tidak Valid';
    $query = $db->query("SELECT * FROM `news` WHERE `urlpage` = '$url'");

    if($query){
        $jumlah_data = $query->num_rows;
        if($jumlah_data == 1){
            $validasi = "valid";
        }
        if($validasi != 'valid'){ echo'<script type="text/javascript">window.history.go(-1)</script>'; die(); }
    }else{
        echo'<script type="text/javascript">window.history.go(-1)</script>'; die();
    }
}

function get_data_member_by_token_login($token_login){
    $a = global_select_single("member","*","token = '$token_login'");
    return $a;
}

function countrylist($country){
    global $db;
    $query = $db->query("SELECT DISTINCT(`country`) FROM `ongkir` ORDER BY `country` ASC");
    while($row = $query->fetch_assoc()):

        echo '<option value="'.$row['country'].'"'.is_selected($country,$row['country']).'>'.ucwords($row['country']).'</option>';
    endwhile;       
}

function propinsilistedit($country,$propinsi){
    global $db;
    $query = $db->query("SELECT DISTINCT(`propinsi`) FROM `ongkir` WHERE `country`='$country' ORDER BY `propinsi` ASC");
    
    while($row = $query->fetch_array()):
        echo '<option value="'.$row['propinsi'].'"'.is_selected($row['propinsi'],$propinsi).'>'.ucwords($row['propinsi']).'</option>';
    endwhile;       
}

function kabupatenlistedit($propinsi,$kabupaten){
    global $db;
    
    $query = $db->query("SELECT DISTINCT(`kabupaten`) FROM `ongkir` WHERE `propinsi`='$propinsi' ORDER BY `kabupaten` ASC");
    while($row = $query->fetch_array()):
        echo '<option value="'.$row['kabupaten'].'"'.is_selected($row['kabupaten'],$kabupaten).'>'.ucwords($row['kabupaten']).'</option>';
    endwhile;       
}   

function kotalistedit($kabupaten,$idkota){
    global $db;
    
    $query = $db->query("SELECT `id`,`nama_kota` FROM `ongkir` WHERE `kabupaten`='$kabupaten' ORDER BY `nama_kota` ASC");
    while($row = $query->fetch_array()):
            echo '<option value="'.$row['id'].'"'.is_selected($row['id'],$idkota).'>'.ucwords($row['nama_kota']).'</option>';
    endwhile;       
}

function get_kota_from_id($id,$table){
    $a = global_select_single($table,"nama_kota","id = '$id'");
    $b = $a['nama_kota'];
    return $b;
}

function get_id_from_urlpage($urlpage,$table){
    $a = global_select_single($table,"id","urlpage = '$urlpage'");
    $b = $a['id'];
    return $b;
}

function get_gender_from_urlpage($string_gender,$table){
    $a = global_select_single($table,"id","title = '$string_gender'");
    $b = $a['id'];
    return $b;
}

function get_gender_from_id($id,$table){
    $a = global_select_single($table,"title","id = '$id'");
    $b = $a['title'];
    return $b;
}

function get_fit_from_urlpage($string_fit,$table){
    $a = global_select_single($table,"id","type = '$string_fit'");
    $b = $a['id'];
    return $b;
}

function get_fit_from_id($id,$table){
    $a = global_select_single($table,"type","id = '$id'");
    $b = $a['type'];
    return $b;
}

function get_idsize_from_urlpage($size,$table){
    $a = global_select_single($table,"id","title = '$size'");
    $b = $a['id'];
    return $b;
}

function get_size_from_id($id,$table){
    $a = global_select_single($table,"title","id = '$id'");
    $b = $a['title'];
    return $b;
}

function pagenum($halaman,$batas){
    if($halaman == 0){
        $halaman = 0;
    }
    if($halaman > 0){
        $halaman = $halaman-1;
    }
    return $halaman*$batas;
}

function log_activity($param){
    $ip = $_SERVER['REMOTE_ADDR'];
    $arr['ip_address'] = $ip;
    $arr['description'] = $param;
    $arr['publish'] = 1;
    $arr['modified_datetime'] = date("Y-m-d h:i:s");
    $arr['modified_by'] = 1;
    global_insert('log_activity',$arr);
}

function random_char($length = 1000) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_token(){
    $a = random_char();
    $hasil = sha1(md5(sha1($a)));
    return $hasil;
}

function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}

function get_new_sortnumber($table_name, $sort_field_name='sortnumber') {
  $theLast = global_select_single($table_name, "MAX(`".$sort_field_name."`) AS max_sortnumber");
  return $theLast['max_sortnumber']+1;
}

function replace_to_dash($text){
		$str = array("’" , "/", " " , ":", "(", ")" , "?" , "%" , "," , "." , "!" , "#" , "$" , "@" , "^" , "&" , "\"" , "\\" , "\r\n" , "\n" , "\r" , "'", "rsquo;","_");
		$newtext=str_replace($str,"-",strtolower($text));
		return $newtext;
}

function replace_to_space($text) {
  $str = array("-","_");
	$newtext = ucwords(str_replace($str, " ", strtolower($text)));
	return $newtext;
}

function upload_myfile($name,$folder,$rename_to){
  // get file name & upload
  $tmpt_folder    = $folder;
  $image          = $_FILES[$name]['tmp_name'];                   // get temp name
  $image_name     = $_FILES[$name]['name'];                       // get name
  $image_baru     = multi_upload($image,$image_name,$tmpt_folder,$rename_to);
  if($image_baru){
      return $image_baru;
  } else{
      return false;
  }
}

function multi_upload($img, $img_, $tmpt_folder, $rename_to){

	$imgbaru = $rename_to."-".date("Y-m-d-His");
	$extG    = get_file_extension($img_);
	$ext     = '.'.$extG;
	$checkextimg = strtolower($extG);
	if(in_array($checkextimg, array("jpg", "jpeg", "png", "gif", "pdf", "xls", "doc", "mov", "ico", "mp4", "ogv", "webm"))):

  	$imgname = $imgbaru.$ext;
  	$dest    = $tmpt_folder.$imgname;

  	if($img_ == '') {
      $nama_gambar = '';
    } else {
      $nama_gambar = $imgname;
    }
    move_uploaded_file($img,$dest);
		return $nama_gambar;
	else:
		$nama_gambar='';
	endif;	
}

function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

function is_selected($compare1,$compare2){
	if($compare1 == $compare2){
		$selected = "selected='selected'";
		return $selected;
	}else{
		return false;
	}
}

function is_checked($compare1,$compare2){
    if($compare1 == $compare2){
        $selected = "checked";
        return $selected;
    }else{
        return false;
    }
}

function form_clean($arr) {
    global $db;

    $new_arr = array();
    foreach($arr AS $key => $val) {
      if(is_array($val)) { // If the post data is an array
        foreach($val AS $key2 => $val2) {
          $new_arr[$key][$key2] = $db->real_escape_string($val2);
        }
      } else {
        $new_arr[$key] = $db->real_escape_string($val);
      }      
    }

    return $new_arr;
}

function global_insert($table_name, $arr_data, $debug=false) {
    global $db;
    $str_column = "";
    $str_values = "";
    foreach($arr_data AS $key => $val) {
        $str_column .= ($str_column == "" ? "":", ")."`".$key."`";
        $str_values .= ($str_values == "" ? "":", ")."'".$val."'";
    }

    $str = "INSERT INTO `".$table_name."`(".$str_column.") VALUES(".$str_values.")";
    if($debug) { echo $str; exit; }

    $result = $db->query($str) or die($db->error);
    if($result)
        return $db->insert_id;

    return false;
}

function global_update($table_name, $arr_data, $str_where, $debug=false) {
    global $db;

    $str_set = "";
    
    foreach($arr_data AS $key => $val) {
        $str_set .= ($str_set == "" ? "":", ")."`".$key."` = '".$val."'";
    }

    $str = "
        UPDATE `".$table_name."` 
        SET ".$str_set."
        WHERE ".$str_where."
    ";

    if($debug) { echo $str; exit; }
    
    $result = $db->query($str) or die($db->error);

    if($result)
        return true;

    return false;
}

function global_delete($table_name, $str_where) {
    global $db;

    $str = "DELETE FROM `".$table_name."` WHERE ".$str_where." ";

    $result = $db->query($str);

    if($result){
        return 1;
    }else{
        return 0;
    }
}

function global_select_single($table_name, $str_select, $str_where=false, $str_order=false, $str_limit=false, $debug_mode=false) { 
    global $db;

    $str = "
        SELECT ".$str_select." 
        FROM ".$table_name."
        ".($str_where ? "WHERE ".$str_where : "")."
        ".($str_order ? "ORDER BY ".$str_order : "")."
        ".($str_limit ? "LIMIT ".$str_limit : "")."
    ";
    if($debug_mode) { echo $str; exit; }

    $result = $db->query($str);
    if($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        return $row;
    }
    
    return false;
}

function select_custom($str) {
	//update by RNT 27 nov 15  ( $result )
    global $db;
    $result = $db->query($str);
    if($result):
		if($result->num_rows > 0) { 
			$arr_return_data = array();
			while($row = $result->fetch_assoc()) {
				array_push($arr_return_data, $row);
			}
			return array(
					'row'=> $arr_return_data,
					'total'=>$result->num_rows
			);
		}
	endif;
    return false;
}

function global_select_field($table_name, $str_field_name, $str_where=false, $str_order=false, $str_limit=false, $debug_mode=false) { 
    global $db;

    $str = "
        SELECT ".$str_field_name." 
        FROM ".$table_name."
        ".($str_where ? "WHERE ".$str_where : "")."
        ".($str_order ? "ORDER BY ".$str_order : "")."
        ".($str_limit ? "LIMIT ".$str_limit : "")."
    ";
    if($debug_mode) { echo $str; exit; }

    $result = $db->query($str);
    if($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        return $row[$str_field_name];
    }
    
    return false;
}

function global_select($table_name, $str_select, $str_where=false, $str_order=false, $str_limit=false, $debug_mode=false) {
    global $db;
    
    //if($str_order === false) { $str_order = "sortnumber ASC"; } 
    
    $str = "
        SELECT ".$str_select." 
        FROM ".$table_name."
        ".($str_where ? "WHERE ".$str_where : "")."
        ".($str_order ? "ORDER BY ".$str_order : "")."
        ".($str_limit ? "LIMIT ".$str_limit : "")."
    ";

    if($debug_mode) { echo $str; exit; }

    $result = $db->query($str);
    
    if($result->num_rows > 0) { 
        $arr_return_data = array();
        while($row = $result->fetch_assoc()) {
            array_push($arr_return_data, $row);
        }
        return $arr_return_data;
    }

    return false;
}

function num_rows($table_name, $str_select, $str_where=false, $str_order=false) {
    global $db;

    $str = "
        SELECT ".$str_select." 
        FROM `".$table_name."` 
        ".($str_where ? "WHERE ".$str_where : "")."
        ".($str_order ? "ORDER BY ".$str_order : "")."
    ";

    $result = $db->query($str);
    if($result->num_rows > 0) {
        return $result->num_rows;
    }

    return $result->num_rows;
}

function print_block($data, $title="PRINT BLOCK") {
    echo "<div style='margin:20px; padding:10px; border:1px solid #666; box-shadow:0px 0px 10px #ccc; border-radius:6px;'>";
    echo "  <div style='padding:10px 5px; margin-bottom:10px; font-weight:bold; font-size:120%; border-bottom:1px solid #666'>".$title."</div>";
    if(is_array($data) OR is_object($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo $data;
    }
    echo "</div>";
}

function print_exit($data, $title="PRINT BLOCK") {
    print_block($data, $title="PRINT BLOCK");
    exit;
}

function flashdata($type, $message) {
    if(isset($_SESSION['flashdata'])) {
      unset($_SESSION['flashdata']);
    }
    $_SESSION['flashdata'] = array("type" => $type, "message" => $message);
}

function flash_success($message) {
    flashdata("success", $message);
}

function flash_error($message) {
    flashdata("error", $message);
}

function redirect($url=false) {
  echo "<script>location.href='".$url."';</script>";
  exit;
}

function ymd_to_dmy($str) {
    if(str_replace(array("-", "/"), "", $str) == "")
        return "";
    return substr($str, 8, 2)."-".substr($str, 5, 2)."-".substr($str, 0, 4);
}

function dmy_to_ymd($str) {
    if(str_replace(array("-", "/"), "", $str) == "")
        return "";
    return substr($str, 6, 4)."-".substr($str, 3, 2)."-".substr($str, 0, 2);
}