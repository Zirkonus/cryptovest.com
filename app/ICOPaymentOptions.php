<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOPaymentOptions extends Model
{
    protected $table = "ico_payment_options";
    protected $fillable = [
        'ico_payment_type_id',
        'payment_key',
        'price'
    ];
    public function getType()
    {
        return $this->belongsToMany(ICOPaymentType::class, 'ico_payment_type_id', 'id');
    }
}
