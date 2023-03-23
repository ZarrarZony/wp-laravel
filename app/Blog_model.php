<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog_model extends Model
{
protected $table = "site_blogs";
protected $guarded = [];
protected $primaryKey = "blog_id";
public $timestamps = true;

    public function categories()
    {
        return $this->belongsToMany('App\Categories_Model','blog_categories','blog_id','cat_id');
    }

    public function stores()
    {
        return $this->belongsToMany('App\Store_Model','blog_stores','blog_id','store_id');
    }

}
