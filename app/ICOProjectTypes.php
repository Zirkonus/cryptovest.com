<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOProjectTypes extends Model
{
	protected $table = 'ico_project_types';

	protected $fillable = [
		'name',
		'is_active',
	];

	public $timestamps = false;
}
