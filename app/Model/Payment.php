<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['tarif_id', 'user_id', 'rub_type', 'subscription', 'mode', 'reference', 'ending'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function accTarif()
    {
        return $this->belongsTo('App\Model\Acc\AccTarif', 'tarif_id');
    }

    public function restauTarif()
    {
        return $this->belongsTo('App\Model\Restau\RestauTarif', 'tarif_id');
    }
}

