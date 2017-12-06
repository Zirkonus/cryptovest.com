<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'status_id',
        'writer_name',
        'writer_email',
        'content',
        'submited_at',
        'ip'
    ];

    public function getPost()
    {
        return $this->hasOne('App\Post', 'id', 'post_id');
    }

	public function getStatus()
	{
		return $this->hasOne('App\Status', 'id', 'status_id');
	}
}
