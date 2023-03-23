<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Relations_Model extends Model
{
	protected $table = "store_coupons";
	protected $fillable = []; //allow fields to enter data from Input::all();
    public $timestamps = false;
}
