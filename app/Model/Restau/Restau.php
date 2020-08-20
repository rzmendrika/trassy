<?php

namespace App\Model\Restau;

use App\Model\Payment;
use Illuminate\Database\Eloquent\Model;

class Restau extends Model
{
    const PARKING_ID     = 1;
    const TYPE_ID        = 2;
    const SPECIALITY_ID  = 3;
    const DESCRIPTION_ID = 4;
    const MENU_ID        = 5;

    protected $pics = [];
    protected $fillable = ['parking', 'opening', 'closing', 'delivery', 'min_price', 'max_price', 'description', 'name', 'days', 'wifi'];
    protected $hidden   = ['created_at', 'updated_at', 'user_id', 'payment_id'];
    protected $pictures = null;

    public function scopeGuestRestau($query, $allPhotos = false)
    {
        $relationships = ['specialities', 'types'];
        $r['pictures'] = function($query) {
            return $query->where('restau_pictures.type', Restau::DESCRIPTION_ID);
        };

        $relationships[] = $allPhotos ? $r : 'pictures';

        return $query->join('payments'   , 'payments.id', 'restaus.payment_id')
                    ->where('payments.ending', '>=', date('Y-m-d') )
                    ->select('restaus.*')
                    ->distinct('restaus.id')
                    ->with($relationships);
    }


    public function scopeOpenOnWeekend($query)
    {
        return $query->where( function($q)
            {
                return $q->where('days', 'LIKE', '%6%')->orWhere('days', 'LIKE', '%7%');
            }
        );
    }

    public function scopeWhereSpecialities($query, $specialities)
    {
        $specialities = explode(',', $specialities);

        return $query->join('restau_restau_speciality', 'restau_restau_speciality.restau_id', 'restaus.id')
                     ->whereIn('restau_restau_speciality.restau_speciality_id', $specialities);
    }

    public function scopeWhereTypes($query, $types)
    {
        $types = explode(',', $types);

        return $query->join('restau_restau_type', 'restau_restau_type.restau_id', 'restaus.id')
                     ->whereIn('restau_restau_type.restau_type_id', $types);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function contacts()
    {
        return $this->hasMany('App\Model\Contact', 'rub_id')
                    ->where('rub_type', config('global.restau.id'));
    }


    public function menus()
    {
        return $this->hasMany('App\Model\Restau\Menu');
    }

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment', 'payment_id');
    }

    public function tarif()
    {
        if( session('tarif.restau') == null )
        {
            $tarif   = $this->payment->restauTarif;

            session(['tarif.restau' => $tarif]); // set session
        }

        return session('tarif.restau');
    }

    public function types()
    {
        return $this->belongsToMany('App\Model\Restau\RestauType');
    }

    public function specialities()
    {
        return $this->belongsToMany('App\Model\Restau\RestauSpeciality');
    }

    public function pictures()
    {
        return $this->hasMany('App\Model\Restau\RestauPicture', 'parent_id');
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
            if( $pic->type == Restau::PARKING_ID)
                $pics[] = $pic;
        }

        return $pics;
    }

    public function specialityPictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Restau::SPECIALITY_ID)
                $pics[] = $pic;
        }

        return $pics;
    }

    public function typePictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Restau::TYPE_ID)
                $pics[] = $pic;
        }
        return $pics;
    }

    public function descriptionPictures()
    {
        $pics = [];

        foreach ($this->getPictures() as $pic)
        {
            if( $pic->type == Restau::DESCRIPTION_ID)
                $pics[] = $pic;
        }
        return $pics;
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
