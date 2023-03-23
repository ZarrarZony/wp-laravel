<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Banner_Model extends Model
{
protected $table = "site_banner";
protected $guarded = [];
protected $primaryKey = "ban_id";
public $timestamps = false;
}
