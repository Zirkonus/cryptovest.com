<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = [
        'country_code',
        'language_code',
        'name',
        'is_active',
        'is_english',
        'is_main'
    ];

    public $timestamps = false;
}
