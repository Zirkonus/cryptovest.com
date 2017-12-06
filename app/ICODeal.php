<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICODeal extends Model
{
    protected $table = 'ico_deals';

    protected $fillable = [
        'ico_buyer_id',
        'ico_projects_id',
        'payment_type_id',
        'payment_option',
        'total_coast',
        'ip_address'
    ];

    public function getICOBuyer()
    {
        return $this->belongsTo(ICOBuyer::class, "ico_buyer_id", "id");
    }
}
