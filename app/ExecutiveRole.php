<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExecutiveRole extends Model
{
    protected $table = 'executive_roles';

    protected $fillable = [
        'name'
    ];
}
