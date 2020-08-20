<?php

namespace App\Model\Restau;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RestauPicture extends Model
{
    protected $fillable = ['path', 'type', 'child_id'];
    protected $hidden   = ['created_at', 'updated_at'];
	public $timestamps  = false;

    public function getPathAttribute()
    {
        return $this->smallPath();
    }

    public function largePath()
    {
        return Storage::disk('public')->url( '/restaus/large/' . $this->attributes['path']);
    }
    
    public function smallPath()
    {
        return Storage::disk('public')->url( '/restaus/small/' . $this->attributes['path']);
    }

    public function restau()
    {
        return $this->belongsTo('App\Model\Restau\Restau', 'parent_id');
    }

    public function fullDelete()
    {
        Storage::disk('public')->delete( '/restaus/small/' . $this->attributes['path']);
        Storage::disk('public')->delete( '/restaus/large/' . $this->attributes['path']);

        return $this->delete();
    }
}
