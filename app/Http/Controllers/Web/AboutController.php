<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sites_Model;
use App\Page_model;
use DB;
//test
class AboutController extends Controller
{
    public $pagemodel;
    public function __construct()
    {
        $this->middleware('auth');
        $this->pagemodel=new Page_model;
    }
    public function index()
    {
        $site_id=config('app.site_id');
        $page_data=$this->pagemodel->select('*')->where(['site_id'=>$site_id,'page_for'=>'about'])->first();
        if(empty($page_data)){
        echo "About-us page not found please create it first";
        die();
        }
        if($page_data->publish==0){
            echo "The page you are trying to access is not publish please make it publish first";
            die();
        }
        $modules_decode=json_decode($page_data->page_modules,true);
        $page_data->page_modules=$modules_decode; 
        $template=$page_data->page_template;
        return view('web.templates.Pages.'.$page_data->page_for.'.'.$template,compact('page_data'));
    }
}
