<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use DB;

class SiteinfoComposer
{
     public $site_info;
    public function __construct()
    {
        $this->getsiteinfo();
    }
    public function getsiteinfo(){
        //Getting Site Menu
        $site_id=config('app.site_id');
        $site_info_db=DB::table('sites')->select('*')->where(['site_id'=>$site_id])->first();  
        $this->site_info=$site_info_db;  
    }
    public function compose(View $view)
    {
        $view->with('site', $this->site_info);
    }
}