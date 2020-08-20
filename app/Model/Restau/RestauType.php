<?php

namespace App\Model\Restau;

use Illuminate\Database\Eloquent\Model;

class RestauType extends Model
{
    protected $fillable = ['name'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function restaus()
    {
        return $this->belongsToMany('App\Model\Restau\Restau');
    }
}
