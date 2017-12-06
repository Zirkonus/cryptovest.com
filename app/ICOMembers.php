<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOMembers extends Model
{
	protected $table = 'ico_members';

	protected $fillable = [
		'ico_id',
		'first_name',
		'last_name',
		'position',
		'twitter_link',
		'linkedin_link',
	];

	public function getICO()
	{
		return $this->belongsTo('App\ICOProjects', 'ico_id');
	}

}
