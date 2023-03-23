<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu_model extends Model
{
protected $table = "site_menu";
protected $guarded = [];
protected $primaryKey = "id";
public $timestamps = false;
}
