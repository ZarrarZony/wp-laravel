<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog_model;
use App\Page_model;
use DB;
//test
class BlogController extends Controller
{
    public $site_id;
    public $blogmodel;
    public $pagemodel;
    public function __construct()
    {
        $this->site_id=config('app.site_id');
        $this->blogmodel=new Blog_Model;
        $this->pagemodel=new Page_model;
    }
    public function index()
    {
        //Gathering Site Data
        $page_data=$this->pagemodel->select('*')->where(['site_id'=>$this->site_id,'page_for'=>'Blog'])->first();
        if(empty($page_data)){
        echo "blog page not found please create it first";
        die();
        }
        if($page_data->publish==0){
            echo "The page you are trying to access is not publish please make it publish first";
            die();
        }
        $modules_decode=json_decode($page_data->page_modules,true);
        $page_data->page_modules=$modules_decode; 
        //gather site blogs
        $site_blogs=$this->blogmodel->select('*')->where('site_id',$this->site_id)->get();
        $site_blogs=json_decode(json_encode($site_blogs),true);
        $template=$page_data->page_template;
        foreach ($site_blogs as $blogs) {
            $words=implode(' ', array_slice(explode(' ', $blogs['content']), 0, 10));
            $blogs['content']=$words;
        }
        return view('web.templates.Pages.'.$page_data->page_for.'.'.$template,compact('page_data','site_blogs'));
    }
}
