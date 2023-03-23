<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Store_Model extends Model
{
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
protected $table = "site_stores";
protected $primaryKey = "store_id";
public $timestamps = false;
protected $guarded = [];

    //testing
    public function getdata()
    {
    return $this->hasOne('App\Coupons_Model','store_id','store_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Categories_Model','store_category','store_id','cat_id');
    }

}
