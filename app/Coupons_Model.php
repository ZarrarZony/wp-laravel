<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Coupons_Model extends Model
{
protected $table = "site_coupons";
protected $guarded = [];
protected $primaryKey = "coupon_id";
public $timestamps = false;
//bring each coupon related categories
    public function categories()
    {
        return $this->belongsToMany('App\Categories_Model','coupons_categories','coupon_id','cat_id');
    }

    public function store()
    {
    	//not possible right now because i dont have the coupon_id in store table right now
        return $this->belongsTo('App\Store_Model','coupon_id','coupon_id');
    }

}
