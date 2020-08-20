<?php

namespace App\Model\Acc;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    protected $hidden   = ['created_at', 'updated_at'];
    protected $fillable = ["name"];
}
