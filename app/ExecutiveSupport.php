<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExecutiveSupport extends Model
{
    protected $table = 'executives_supports';

    protected $fillable = [
        'name'
    ];
}
