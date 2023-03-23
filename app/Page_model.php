<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page_model extends Model
{
protected $table = "sites_pages";
protected $guarded = [];
protected $primaryKey = "page_id";
public $timestamps = false;
}
