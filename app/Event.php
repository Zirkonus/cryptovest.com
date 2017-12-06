<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function getPromotion()
    {
        return $this->hasOne('App\ICOPromotion', 'id', 'ico_promotion_id');
    }
}
