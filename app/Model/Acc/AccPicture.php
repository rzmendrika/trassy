<?php

namespace App\Model\Acc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AccPicture extends Model
{
    protected $fillable = ['path', 'type', 'child_id'];
    protected $hidden   = ['created_at', 'updated_at'];
	public $timestamps  = false;
    
    public function largePath()
    {
        return Storage::disk('public')->url( '/accs/large/' . $this->path);
    }
    
    public function getPathAttribute($path)
    {
        return Storage::disk('public')->url( '/accs/small/' . $path);
    }

    public function acc()
    {
        return $this->belongsTo('App\Model\Acc\Acc', 'parent_id');
    }

    public function fullDelete()
    {
        $path = $this->attributes['path'];

        Storage::disk('public')->delete( '/accs/small/' . $path);
        Storage::disk('public')->delete( '/accs/large/' . $path);

        return $this->delete();
    }
}
