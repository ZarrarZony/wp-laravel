<?php

function isJson($string) {
  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
}
function checkIfFileExistOnS3($string) {
  $s3 = Storage::disk('s3');
  if($s3->exists($string)){
    return true;
  }else{
    return false;
  }
}
function checktextandreturnCorrent($_param) {
  if(empty($_param)) return '';
	$checkjson = isJson($_param);
	if($checkjson === true){
    $_param = json_decode($_param, true);
    if(is_array($_param) && !empty($_param) && isset($_param[0])){
		  $_param = $_param[0];
  		return $_param;
    }
    else{
		  return '';
    }
  }else{
    return $_param;
	}
}
function getTextFromJsonWithInJson($text){
  $ret_ofset = config('app.site_id');
  $var = json_decode($text, true);
  if(config('app.site_id') && array_key_exists($ret_ofset,$var)){
	  $var = $var[$ret_ofset];
  	if(isJson($var) === true){
  		$var = json_decode($var, true);
  		return $var[0];
  	}
    else{
      return $var;
    }
  }
  else{
    return getTextFromJsonForAdmin($text);
  }
}
function getTextFromJson($text){
  $var = json_decode($text, true);
  if(config('app.site_id')){
	  $var = $var[config('app.site_id')];
  	return $var;
  }
  else{
    return getTextFromJsonForAdmin($text);
  }
}
function currentSite_id(){
    //Work For website Language
    $site = Input::input("site");
    if(!empty($site) && !is_numeric($site)){
        return get_secure_id($site);
    }else if(!empty($site) && is_numeric($site)){
        return $site;
    }
    return defaultSite_id();
}
function defaultSite_id(){
    $site_id  = Setting::get_web_setting("default_site");
    return $site_id;
}
function getTextFromJsonForAdmin($jsonData,$site_id=""){
  if(empty($site_id)){
    $site_id    = currentSite_id();
    $default_id = defaultSite_id();
  }
  @$tempA = json_decode($jsonData,true);
  if(!is_array($tempA)){
    return $jsonData;
  }
  // dd($tempA[$site_id]);
  @$temp = $tempA[$site_id];
  if(empty($temp)){
    @$temp  = $tempA[$default_id];
    if(empty($temp)){
            //if still key not found then first key of array return in case of default... else blank return
      $temp = $tempA[key($tempA)];
    }
  }
  return $temp;
}
function find_in_array($obj_data, $search_key, $return_column="setting_value", $column_name="setting_name")
{
  if (!(empty($obj_data))) {
    foreach ($obj_data as $val) {
      $val = (array) $val;
      if(isset($val[$column_name]) && $val[$column_name] == $search_key) {
        // dump($val[$column_name],$search_key);
        if($return_column=="all"){
          return $val;
        }
        if($search_key=="faq_content"){
          return $val['info'];
        }else{
          // dump($val[$return_column]);
          return $val[$return_column];
        }
      }
    }
  }
  return "";
}
function find_in_array_custom($obj_data, $search_key, $store_module_id, $return_column="setting_value", $column_name="setting_name")
{
  if (!(empty($obj_data))) {
    foreach ($obj_data as $val) {
      if($val->module_id == $store_module_id){
        if(isset($val->setting_name) && $val->setting_name == $search_key) {
          if($return_column=="all"){
            return $val;
          }else{
            return $val->$return_column;
          }
        }
      }
    }
  }
  return "";
}
function correctImageLink($Url){
  $temp = str_replace("{{WEB_URL}}",session('IMAGES_URL'),$Url);
  return $temp;
}
function couponPercentage($couponTitle){
  $couponTitle = strtolower($couponTitle);
  $temps = explode(' ', $couponTitle);
  foreach ($temps as $key => $value) {
    if(strpos($value,"%") !== false){
      $return_array = [$value, 'OFF'];
      return $return_array;
    }
  }
  foreach ($temps as $key => $value) {
    if ($value == "free"){
      if(preg_match("/delivery|shipping/is", $couponTitle)){
        $return_array = ['FREE', 'SHIPPING'];
        return $return_array;
      }
    }
  }
}
function strafter($string, $substring) {
  $pos = strpos($string, $substring);
  if ($pos === false)
   return $string;
 else
   return(substr($string, $pos+strlen($substring)));
}

function strbefore($string, $substring) {
  $pos = strpos($string, $substring);
  if ($pos === false)
   return $string;
 else
   return(substr($string, 0, $pos));
}
// Function to get the client IP address
function get_client_ip() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
    $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}
function ip_details($IPaddress)
{
  $json       = file_get_contents("http://ipinfo.io/{$IPaddress}");
  $details    = json_decode($json, true);
  return $details;
}
function get_ip_details($IPaddress)
{
  $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  $url = "http://freegeoip.net/json/$ip";
  $ch  = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  $data = curl_exec($ch);
  curl_close($ch);
  if ($data) {
    $location = json_decode($data, true);
    $lat = $location->latitude;
    $lon = $location->longitude;
    $sun_info = date_sun_info(time(), $lat, $lon);
    print_r($sun_info);
  }
}