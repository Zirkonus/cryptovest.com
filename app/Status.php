<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'is_comment',
        'is_post'
    ];

    public $timestamps = false;
}
