<?php

namespace App\Model\Restau;

use Illuminate\Database\Eloquent\Model;

class RestauSpeciality extends Model
{
    protected $hidden   = ['created_at', 'updated_at'];
    protected $fillable = ['name'];

    public function restaus()
    {
        return $this->belongsToMany('App\Model\Restau\Restau');
    }
}
