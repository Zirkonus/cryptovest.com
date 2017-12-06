<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOComments extends Model
{
	protected $table = 'ico_comments';

	protected $fillable = [
		'ico_id',
		'status_id',
		'writer_name',
		'writer_email',
		'content',
		'submited_at',
        'ip'
	];

	public function getICO()
	{
		return $this->hasOne('App\ICOProjects', 'id', 'ico_id');
	}

	public function getStatus()
	{
		return $this->hasOne('App\Status', 'id', 'status_id');
	}
}
