<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use DB;

class MenuComposer
{
    public $site_menu=array();
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getsitemenu();
    }
    public function getsitemenu(){
       //Getting Site Menu
        $site_id=config('app.site_id');
        $site_menu_db=DB::table('site_menu')->select('menu')->where(['site_id'=>$site_id])->get();
        $site_menu_db=json_decode($site_menu_db[0]->menu,true);
        foreach ($site_menu_db as $key => $value) {
            if($value!=null){
             $this->site_menu[$key]=$value;
            }
        }
    }
    public function compose(View $view)
    {
        $view->with('site_menu', $this->site_menu);
    }
}