<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaType extends Model
{
    protected $table = 'meta_types';

    protected $fillable = [
        'type',
        'type_value'
    ];

    public $timestamps = false;
}
