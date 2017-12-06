<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $table = 'social_links';

    protected $fillable = [
        'user_id',
        'url',
        'name'
    ];

    public $timestamps = false;
}
