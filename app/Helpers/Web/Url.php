<?php
use App\Sites_Model as SITES;
use Storage as Storage;
function start_query_debug(){
    \DB::enableQueryLog();
}

//isjson(amir function)
function isJson($string) {
  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
}

//get headers and footers
function getheadfoot($request){
        $temp_header=[];
        $temp_footer=[];
        if($request=='header'){
        $header_dir   = resource_path('views/web/templates/headers');
        $files = scandir($header_dir);
        foreach ($files as $key => $value) {
            if($value !='.' && $value !='..'){
                $file=explode('.', $value);
                $efile=$file[0];
                $temp_header[$efile]=$efile;
            }
         }
         return $temp_header;
       }
        if($request=='footer'){
        $footer_dir   = resource_path('views/web/templates/footers');
        $files = scandir($footer_dir);
        foreach ($files as $key => $value) {
            if($value !='.' && $value !='..'){
                $file=explode('.', $value);
                $efile=$file[0];
                $temp_footer[$efile]=$efile;
            }
          }
          return $temp_footer;
       }
}

function uploadFileToS3Bucket($param1, $param2, $param3, $param4){
    $param1 = renameUploadFile($param1);
    $s3 = Storage::disk('s3');
    if($param3 != ''){
        if(is_numeric($param3)){
            $param3 = getSiteShortNameBySiteIds($param3);
        }
        $filePath = '/laravel-wordpress/admin/sites/'.$param3.'/'.$param4.'/'.$param1;
        if(!($s3->exists($filePath))){
            $s3->put($filePath, $param2, 'public');
        }
        return true;
    }
    else{
        $filePath = '/admin/category/'.$param1;
        if(!$s3->exists($filePath)){
            $s3->put($filePath, $param2, 'public');
        }
        return true;
    }
}


//amir function
function getSiteShortNameBySiteIds($SiteIds){
    if($SiteIds == '') return '';
  // echo $SiteIds; die;
    if( strpos($SiteIds, '[')  &&  strpos($SiteIds, ']') ){
        $Site_Ids = json_decode($SiteIds, true);
        if(count($Site_Ids)>1){
            return '';
        }
        $get_Site__by_Ids = SITES::where('site_id' , $Site_Ids[0])->first();
        return $get_Site__by_Ids->short_name ? $get_Site__by_Ids->short_name : '';
    }
    else{
        $get_Site__by_Ids = SITES::where('site_id' , $SiteIds)->first();
        if($get_Site__by_Ids)
            return $get_Site__by_Ids->short_name;
        else
            return "";
    }
}

//rename files
function renameUploadFile($param){
    return preg_replace("/[^A-Za-z0-9\_\-\.]/", '', $param);
}

//myfunction for upload images
function uploadimagetolocal($folder,$name,$file){
    Storage::disk('public')->put($folder.'/'.$name,$file);
}

function show_queries(){
    dd(\DB::getQueryLog());
}
function show_queries_2(){
    echo '<pre>';
    print_r(\DB::getQueryLog());
    echo '</pre>';
    die;
}
function current_url($url_string=true)
{
    $url = url()->current();
    if($url_string){
        $url = url()->full();
    }
    $url = rtrim($url,"/");
    return $url;
}

function setConfiGuration($domainparam){
    $domain = '';
    if($domainparam == 'localhost'){
        $checkmydomain=Request::root();
        $checkmydomain=explode('/', $checkmydomain);
        if(isset($checkmydomain[3])){
        $domain = $checkmydomain[3];
    }
    }else{
        $domain = $domainparam;
    }
    $getDomain = \DB::table('sites')->where('url', 'LIKE', '%'.$domain.'%')->first();
    if($getDomain){
        $namespace_name = $getDomain->short_name;
        $namespace_name_org = $namespace_name;
        $namespace_name = 'Web';
        $templete_namespace_name = 'web.'.strtolower($namespace_name_org);
        $request = \Request();
        if($domainparam == 'localhost'){
           $path = public_path();
           $path = explode('\\', $path);
           $path = $path[3];
           $path = str_replace('\\', '/',$path);
           $path = $domainparam.$path;
           $getDomain->url = 'http://'.$path;
       }
        else{
            $getDomain->url = $getDomain->url;
        }
        config([
            'app.name'               => $getDomain->name,
            'app.shortname'          => $getDomain->short_name,
            'app.url'                => $getDomain->url,
            'app.uri'                => $getDomain->url.'/',
            'app.web_url'            => $getDomain->url,
            'app.site_id'            => $getDomain->site_id,
            'app.namespace_name'     => $namespace_name,
            'app.app_path'           => app_path(),
            'app.cdn_local'          => url('/assets/')
        ]);
        return 'config set success';
    }
    else{
        return '';
    }
}

