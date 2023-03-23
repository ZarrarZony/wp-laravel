<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SocialMedia_Model extends Model
{
  // if you want to change then
	protected $table = "site_socialmedia";
	protected $guarded = []; //allow fields to enter data from Input::all();
	//By default primary key is id, if you want to change
	protected $primaryKey = "social_id";
  //if you dont want to use timestamp
  public $timestamps = false;
}
