<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Categories_Model extends Model
{
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
protected $table = "site_categories";
protected $guarded = [];
protected $primaryKey = "cat_id";
public $timestamps = false;

    public function coupons()
    {
        return $this->belongsToMany('App\Coupons_Model','coupons_categories','cat_id','coupon_id');
    }
    //get categories stores
    public function stores()
    {
        return $this->belongsToMany('App\Store_Model','store_category','cat_id','store_id');
    }

    //testing
    public function getdata()
    {
    return $this->hasOne('App\Store_Model');
    }
}
