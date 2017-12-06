<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOBuyer extends Model
{
    protected $table = 'ico_buyers';

    protected $fillable = [
        'name',
        'company',
        'email',
        'mobile',
    ];

    public function ICOProjects()
    {
        return $this->hasMany(ICOProjects::class, 'ico_buyer', 'id');
    }
}
