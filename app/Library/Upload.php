<?php
namespace App\Library;
use Request;
class upload{
  public function __construct(){
    $this->request = Request();
  }
  private $uploadFiles = array(
    /*Image Type*/
    "jpg","jpeg","bmp","gif","png","img","svg","svg+xml",
    /*Files Type*/
    "txt","pdf","psd","docx","doc","pptx","ppt","xlsx","xlr","xls","csv","pps",
    "zip","gzip","rar","gz","tar","tar.gz","ios","max","dwg","eps","ai","torrent",
    "html","css","js","xml","xhtml","rss",
    /*Media Type*/
    "mp4","m4a","mp3","mpg3","3gp","flv","wmv","wav","mqv","mpeg4","swf","mov","mpg","avi","raw","wmv","rm","obj"
  ); // only these type file allow to upload, write in lower case
  private $image_types = array(
    /*Image Type*/
    "jpg","jpeg","bmp","gif","png","img","svg","svg+xml"
  );
  public function is_image_exists($image){
    if($image==''){return false;}
    $image = IMAGE_PATH.$image;
    if(file_exists($image)) {
      return true;
    }else{
      return false;
    }
  }
  // deleteOldSingleImage("05/file.jpg");
  public function deleteOldSingleImage($image){
    if(empty($image)){return false;}
    if($this->is_image_exists($image)) {
      unlink(IMAGE_PATH.$image);
      return true;
    }else{
      return false;
    }
  }
  // check if file type is allow for upload
  public function check_file_allow($filename,$image = false){
    // check file extension, is allow to upload or not,
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if($image){
      // check if image
      if(!empty($ext) && in_array(strtolower($ext),$this->image_types)) {
        return true;
      }
      return false;
    }
    // check all file types
    if(!empty($ext) && in_array(strtolower($ext),$this->uploadFiles)) {
      return true;
    }
    return false;
  }
  // For only images
  public function upload_single_image($name,$folder='mixed',$imgName = ""){
    // Check if file has....
    $request  = $this->request;
    if ($request->hasFile($name)) {
      if ($request->file($name)->isValid()) {
        $file = $request->$name; // return object
        $file_name = $file->getClientOriginalName(); // return file_name.jpg
        $extension = $request->$name->extension(); // extension
        if($this->check_file_allow($file_name,true)==false){
          return array("error" => "File type not allow");
        }
        return $this->upload_single_file($name,$folder,$imgName);
      }
    }
  }
  /**
  * @param $data $field_name
  * @param string $folder
  * @param string $imgName
  * @return bool|string ImgName
  *
  * e.g:   $image = $this->upload_single_file("form_file_name",'deal',"prefix_image name");
  */
  public function upload_single_file($name,$folder='mixed',$imgName=''){
    // Check if file has...
    $request  = $this->request;
    if ($request->hasFile($name)) {
      if ($request->file($name)->isValid()) {
        $file = $request->$name; // return object
        $file_name = $file->getClientOriginalName(); // return file_name.jpg
        $extension = $request->$name->extension(); // extension
        if($this->check_file_allow($file_name,true)==false){
          return array("error" => "File type not allow");
        }
        $path = IMAGE_FOLDER;
        $path = rtrim($path,"/");
        $path = $path.'/';
        $folder = rtrim($folder,"/");
        $folder = $folder.'/';
        $path = $path.$folder;
        $year = date('Y').'/';
        $month = date('m').'/';
        $rand = '';//rand(101,999);
        //create folder pages
        if (!file_exists($path)) {
          mkdir($path, 0777);
        }
        // create folder year
        if (!file_exists($path.$year)) {
          mkdir($path.$year, 0777);
        }
        // create folder month
        if (!file_exists($path.$year.$month)) {
          mkdir($path.$year.$month, 0777);
        }
        $path = $path.$year.$month;
        $realName = $file_name;
        if($imgName!=''){
          // $imgName = $rand.'-'.$imgName.'-'.$realName;
          $imgName = $imgName.'-'.$realName;
        } else {
          // $imgName = $rand.'-'.$realName;
          $imgName = $realName;
        }
        $imgName = sanitize_file_name($imgName);
        // get unique name
        $imgName = $this->get_image_unique_name($path,$imgName);
        $return = $path.$imgName;
        $store = $request->file($name)->move($path,$imgName);
        if($store){
          $path = str_ireplace(IMAGE_FOLDER."/","",$path);
          return $path.$imgName;
        }
        // Upload fail
        return  "";
      }
    }
    return "";
  }
  public function get_image_unique_name($path,$image_name){
    $actual_name = pathinfo($image_name,PATHINFO_FILENAME);
    $original_name = $actual_name;
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $i = 1;
    $new_name = $image_name;
    while(file_exists($path.$actual_name.".".$extension))
    {
      $actual_name = (string)$original_name."-".$i;
      $new_name   = $actual_name.".".$extension;
      $i++;
    }
    return $new_name;
  }
  public function upload_multiple_images($data,$folder='files',$fileName=''){
    return $this->upload_multiple_files($data,$folder,$fileName,true);
  }
  /**
  * @param $data $_FILES['name']
  * @param string $folder where want to save image
  * @param $imgName
  * @return array|string
  * also work in single image.. but return images array not name...
  * e.g: $functions->upload_multiple_images($_FILES['image'],'defect','');
  *
  * only work for single input image tag, but multi select images option
  */
  public function upload_multiple_files($data,$folder='mixed',$imgName='',$check_image=false,$images_folder=true){
    if($images_folder) {
      $path = IMAGE_FOLDER;
    }else{
      $path = UPLOAD_FOLDER;
    }
    if(substr($folder,-1,1)=='/'){}else{
      $folder = $folder.'/';
    }
    $path = $path.$folder;
    $year = date('Y').'/';
    $month = date('m').'/';
    $rand = rand(101,999);
  //create folder pages
    if (!file_exists($path)) {
      mkdir($path, 0777);
    }
  //create folder year
    if (!file_exists($path.$year)) {
      mkdir($path.$year, 0777);
    }
    // create folder month
    if (!file_exists($path.$year.$month)) {
      mkdir($path.$year.$month, 0777);
    }
    $path = $path.$year.$month;
    $imagesReturnName = array();
    $dataTemp       = $data;
    $dataTemp["size"] = is_array($dataTemp["size"]) ? $dataTemp["size"] : array();
    $i = 0;
    foreach($dataTemp["size"] as $key=>$val){
      if(($data["size"][$key])>0)
      {
        $realName = $data["name"][$key];
        if ($data["error"][$key] > 0){
          $imagesReturnName['error'][$key]['error'] = "File size error";
          $imagesReturnName['error'][$key]['name'] = $realName;
          continue;
        }
        else {
          if($this->check_file_allow($realName,$check_image)==false) {
            $imagesReturnName['error'][$key]['error'] = "File type not allow";
            $imagesReturnName['error'][$key]['name'] = $realName;
            continue;
          }
          $i++;
          if($imgName!=''){
            // $this_img_name = $rand.'-'.$i."-".$imgName.'-'.$realName;
            $this_img_name = $imgName.'-'.$realName;
          }else{
            // $this_img_name = $rand.'-'.$i."-".$realName;
            $this_img_name = $realName;
          }
          $this_img_name = sanitize_file_name($this_img_name);
          // get unique name
          $this_img_name = $this->get_image_unique_name($path,$this_img_name);
          $return  = $path.$this_img_name;
          if(move_uploaded_file($data["tmp_name"][$key],$path.$this_img_name)){
            $imagesReturnName['success'][] =   $return;
          }
        }
      }
    }
    return  $imagesReturnName;
  }
  // Not working ,,
  public function do_multi_upload($filed_name){
    $save_images = array();
    $files = $_FILES;
    foreach($files[$filed_name]['name'] as $key=>$val){
      $temp_name = "my_loop_".$key;
      $_FILES[$filed_name]['name']     = $_FILES[$filed_name]['name'][$key];
      $_FILES[$filed_name]['type']     = $_FILES[$filed_name]['type'][$key];
      $_FILES[$filed_name]['tmp_name'] = $_FILES[$filed_name]['tmp_name'][$key];
      $_FILES[$filed_name]['error']    = $_FILES[$filed_name]['error'][$key];
      $_FILES[$filed_name]['size']     = $_FILES[$filed_name]['size'][$key];
      if($this->do_upload($filed_name)){
        $save_images[$key]['name'] = $this->data('file_name');
      }else{
        $save_images[$key]['name'] = $this->display_errors();
      }
    }
  }
  public function kc_finder_images($data,$hidden_name=""){
    if(empty($hidden_name)){
      $hidden_name = "kc_images";
    }
    if(!is_array($data) && !empty($data)){
      $data = json_decode($data,true);
    }
    if(empty($data) || !is_array($data)) return false;
    $html = "";
    foreach($data as $key=>$val){
      $val = config('app.admin.cdnpath_admin').'sites/'.$i.'/websetting/'.($val);
      $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc"><img src="' .$val . '" class="img-responsive"/></div></div>';
    }
    return $html;
  }
  public function kc_finder_images2($data,$hidden_name="", $param=false,$folder){
    $currentpath='laravel-wordpress/admin';
    if(empty($hidden_name)){
      $hidden_name = "kc_images";
    }
    if(!is_array($data) && !empty($data)){
      if(isJson($data) === true){
        $data = json_decode($data,true);
      }
      elseif(is_string($data)){
        $data = json_encode($data);
        $data = json_decode($data,true);
      }
    }
    if(!empty($data) || !is_array($data)){
      $data = (array) $data;
    }
    if(empty($data) || !is_array($data)) return false;
    $html = "";
    if(is_numeric($param)){
      $param = getSiteShortNameBySiteIds($param);
    }
    // dump($data);
    foreach($data as $key => $val){
      if(empty($val)) continue;
      $ext = pathinfo($val, PATHINFO_EXTENSION);
      if($ext == 'svg'){
        $val = config('app.admin.cdnpath_admin').$currentpath.'sites/'.$param.'/'.$folder.'/'.$val;
        $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc">'.file_get_contents($val).'</div></div>';
      }else{
        $val = config('app.admin.cdnpath_admin').$currentpath.'/sites/'.$param.'/'.$folder.'/'.$val;
        $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc"><img src="' .$val . '" class="img-responsive"/></div></div>';
      }
    }
    return $html;
  }
  public function kc_finder_images2_svgs($data,$hidden_name="", $param=false,$folder){
    if(empty($hidden_name)){
      $hidden_name = "kc_images";
    }
    if(!is_array($data) && !empty($data)){
      $data = json_decode($data,true);
    }
    if(empty($data) || !is_array($data)) return false;
    $html = "";
    if(is_numeric($param)){
      $param = getSiteShortNameBySiteIds($param);
    }
    foreach($data as $key=>$val){
      $val = config('app.admin.cdnpath_admin').'sites/'.$param.'/'.$folder.'/'.($val);
      $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc">'.file_get_contents($val).'</div></div>';
    }
    return $html;
  }
  // my function for catagorie
  public function kc_finder_catagorie($data,$hidden_name="", $param=false){
    if(empty($hidden_name)){
      $hidden_name = "kc_images";
    }
    if(!is_array($data) && !empty($data)){
      $data = json_decode($data,true);
    }
    if(empty($data) || !is_array($data)) return false;
    $html = "";
    foreach($data as $key=>$val){
      $ext = pathinfo($val, PATHINFO_EXTENSION);
      if($ext == 'svg'){
        $val = config('app.admin.cdnpath_admin').'category/'.$val;
        $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc">'.file_get_contents($val).'</div></div>';
      }else{
        $val = config('app.admin.cdnpath_admin').'category/'.$val;
        $html .= '<div class="single_img"><input type="hidden" name="'.$hidden_name.'[]" value="'.$val.'" /><div class="img_del">X</div><div class="img_kc"><img src="' .$val . '" class="img-responsive"/></div></div>';
      }
    }
    return $html;
  }
}