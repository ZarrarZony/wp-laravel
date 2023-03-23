<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use DB;

class FooterComposer
{
    public $site_footer=array();
    public function __construct()
    {
        $this->getsitefooter();
    }
    public function getsitefooter(){
       //Getting Site Footer
        $site_id=config('app.site_id');
        $site_footer_db=DB::table('site_footer')->select('*')->where(['site_id'=>$site_id])->get();
        $site_footer_db=json_decode($site_footer_db,true);
/*                        print_r($site_footer_db[0]['footer_name']);
        die();*/
        foreach ($site_footer_db as $key => $value) {
            if($value['content1'] && !empty($value['content1'])){
             $this->site_footer['content1']=$value['content1'];
            }
            if($value['content2'] && !empty($value['content2'])){
             $this->site_footer['content2']=$value['content2'];
            }
             $this->site_footer['footers'][$value['footer_name']]=$value['footer_link'];
             /*$this->site_footer['footer_links'][]=$value['footer_link'];*/
        }
    }
    public function compose(View $view)
    {
        $view->with('site_footer', $this->site_footer);
    }
}