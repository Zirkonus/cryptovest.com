<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscribersCategories extends Model
{
    protected $table = 'subscribers_categories';

    protected $fillable = [
	    'category_id',
        'subscriber_id'
    ];

    public $timestamps = false;
}
