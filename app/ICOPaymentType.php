<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ICOPaymentOptions;

class ICOPaymentType extends Model
{
    protected $table = "ico_payment_type";

    protected $fillable = [
        'name',
        'short_name',
        'link'
    ];
    public function getOptions()
    {
        return $this->hasMany(ICOPaymentOptions::class, 'ico_payment_type_id', 'id');
    }
}
