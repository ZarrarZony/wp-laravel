<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use DB;

class SocialComposer
{
    public $social_link=array();
    public function __construct()
    {
        $this->getsitesocial();
    }
    public function getsitesocial(){
       //Getting Site Footer
        $site_id=config('app.site_id');
        $social_link_db=DB::table('site_socialmedia')->select('*')->where(['site_id'=>$site_id])->get();
        $social_link_db=json_decode($social_link_db,true);
        foreach ($social_link_db as $key => $value) {
             $this->social_link['links'][$value['social_name']]=$value['social_link'];
             $this->social_link['class'][$value['social_class']]=$value['social_link'];
        }
    }
    public function compose(View $view)
    {
        $view->with('social_link', $this->social_link);
    }
}