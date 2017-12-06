<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageValue extends Model
{
    protected $table = 'language_values';

    protected $fillable = [
        'language_id',
        'key',
        'value'
    ];

    public $timestamps = false;
}
