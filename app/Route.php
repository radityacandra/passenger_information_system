<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
	protected $table = 'route';
	public $timestamps = true;
	
	public $fillable = ['rute_id', 'deskripsi'];
}