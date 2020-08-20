<?php

namespace App\Model\Acc;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['bed_numbers', 'tv', 'safe', 'kitchen', 'price', 'shower', 'wc', 'description', 'category_id'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo('App\Model\Acc\RoomCategory', 'category_id');
    }

    public function accomodation()
    {
        return $this->belongsTo('App\Model\Acc\Acc', 'acc_id');
    }

    public function pictures()
    {
        return $this->hasMany('App\Model\Acc\AccPicture', 'child_id')->where('type', Acc::ROOM_ID);
    }

    public function user()
    {
        return $this->accomodation->user;
    }

    public function scopeIsSecure($query, $accId, $id = null)
    {
        $conditions['users.id'] = Auth::user()->id;
        $conditions['accs.id' ] = $accId;

        if( $id !== null )
        {
            $conditions['rooms.id'] = $id;
        }

        $room = Room::join('accs' , 'accs.id' , '=', 'rooms.acc_id')
                    ->join('users', 'users.id', '=', 'accs.user_id')
                    ->with('category')
                    ->where($conditions);

        return ( $id == null ) ? $room->get('rooms.*') : $room->first('rooms.*');
    }
}