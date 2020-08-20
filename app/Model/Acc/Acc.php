<?php

namespace App\Model\Acc;

use App\Model\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Acc extends Model
{
    const PARKING_ID     = 1;
    const TYPE_ID        = 2;
    const ROOM_ID        = 3;
    const DESCRIPTION_ID = 4;

    protected $pics = [];
    protected $fillable = ['name', 'stars', 'parking', 'description', 'days', 'wifi', 'playground', 'roomservice'];
    protected $hidden   = ['created_at', 'updated_at', 'user_id', 'payment_id'];

    public function scopeGuestAcc($query, $allPhotos = false)
    {
        $relationships = ['types'];

        $r['pictures'] = function($query) {
            return $query->where('acc_pictures.type', Acc::DESCRIPTION_ID);
        };

        $relationships[] = $allPhotos ? $r : 'pictures';

        return $query->join('payments', 'payments.id', 'accs.payment_id')
                    ->where('payments.ending', '>=', date('Y-m-d') )
                    ->where('accs.active', true )
                    ->where('accs.principal', true )
                    ->select('accs.*')
                    ->with($relationships);
    }

    public function scopeWhereRooms($query, $categories)
    {
        $categories = explode(',', $categories);

        return $query->join('rooms', 'rooms.acc_id', 'accs.id')
                     ->whereIn('rooms.category_id', $categories);
    }

    public function scopeWhereTypes($query, $types)
    {
        $types = explode(',', $types);

        return $query->join('acc_acc_type', 'acc_acc_type.acc_id', 'accs.id')
                     ->whereIn('acc_acc_type.acc_type_id', $types);
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function contact()
    {
        return $this->hasOne('App\Model\Contact', 'rub_id')
                    ->where('rub_type', config('global.acc.id'));
    }

    public function getActiveAttribute($active)
    {
        return (boolean) $active;
    }

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment', 'payment_id');
    }

    public function tarif()
    {
        if( session('tarif.acc') == null )
        {
            $tarif   = $this->payment->accTarif;

            session(['tarif.acc' => $tarif]); // set session
        }

        return session('tarif.acc');
    }

    public function types()
    {
        return $this->belongsToMany('App\Model\Acc\AccType');
    }

    public function rooms()
    {
        return $this->hasMany('App\Model\Acc\Room');
    }

    public function roomsCategories()
    {
        return $this->hasMany('App\Model\Acc\RoomCategory');
    }

    public function pictures()
    {
        return $this->hasMany('App\Model\Acc\AccPicture', 'parent_id');
    }

    public function getPictures()
    {
        if( $this->pics == [] )
        {
            $this->pics = $this->pictures()->orderBy('id', 'DESC')->limit($this->tarif()->pictures)->get();
        }
        return $this->pics;
    }

    public function parkingPictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Acc::PARKING_ID)
                $pics[] = $pic;
        }

        return $pics;
    }

    public function roomPictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Acc::ROOM_ID)
                $pics[] = $pic;
        }

        return $pics;
    }

    public function typePictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Acc::TYPE_ID)
                $pics[] = $pic;
        }
        return $pics;
    }

    public function descriptionPictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Acc::DESCRIPTION_ID)
                $pics[] = $pic;
        }
        return $pics;
    }

    public function scopeSecure($query, $id = null)
    {
        $conditions['accs.id'] = $id;
        $acc = Auth::user()->accs()
                           ->with('rooms', 'types', 'contact')
                           ->where($conditions)->first();
        $types = [];
        foreach ($acc->types as $type)
        {
            $types[] = $type->id;
        }
        unset($acc->types);
        $acc->types = $types;

        return $acc;
    }

    public function getDaysAttribute($days)
    {
        return explode(',', $days);
    }

    public function setDaysAttribute($days)
    {
        $temp = [];
        foreach ($days as $day)
        {
            $day = (int) $day;
            if( $day > 0 && $day < 8 )
                $temp[] = $day;
        }

        $this->attributes['days'] = implode(',', $temp);
    }

}
