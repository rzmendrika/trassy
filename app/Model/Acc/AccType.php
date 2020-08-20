<?php

namespace App\Model\Acc;

use Illuminate\Database\Eloquent\Model;

class AccType extends Model
{
    protected $fillable = ['name'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function accs()
    {
        return $this->belongsToMany('App\Model\Acc\Acc');
    }
}
