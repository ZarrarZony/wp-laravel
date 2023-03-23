<?php
namespace App\Http\Controllers\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner_Model;
use App\Footer_Model;
use App\Coupons_Model;
use App\Menu_Model;
use App\Store_Model;
use App\Categories_Model;
use DB;
class AjaxController extends Controller
{
    public $site_id='';
    public $bannermodel;
    public $footermodel;
    public $coupon_model;
    public $catmodel;
    public $menumodel;
   public function __construct()
    {
        $this->site_id=config('app.site_id');
        $this->bannermodel=new Banner_Model;
        $this->footermodel=new Footer_Model;
        $this->menumodel=new Menu_Model;
        $this->storemodel=new Store_Model;
        $this->catmodel=new Categories_Model;
        $this->coupon_model=new Coupons_Model;
    }
public function index(){
        $request = Request();
        $data=$request->all();
        if(isset($data['setview']) && $data['setview']=='yes'){
            if(!empty($data['table']) && !empty($data['id']) && !is_int($data['id_value'])){
              return $this->setview($data['table'],$data['id'],$data['id_value']);
            }else{
                return "error";
            }
       }
       //get stores by getting character
       if(isset($data['what_required']) && !empty($data['what_required']=='stores')){
        return $this->get_stores_by_character($data);
       }
}
public function setview($table,$id,$id_value){
    $result=DB::table($table)->where($id, $id_value)->increment('viewed', 1);
}
public function get_stores_by_character($data){
    return $result=DB::table($data['table'])->where('name', 'LIKE',$data['character']."%")->get();
}
}
