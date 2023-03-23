<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites_Model extends Model
{
  // if you want to change then
	protected $table = "sites";
	protected $fillable = ['header','footer'];
	//By default primary key is id, if you want to change
	protected $primaryKey = "site_id";
  //if you dont want to use timestamp
  public $timestamps = false;
}
