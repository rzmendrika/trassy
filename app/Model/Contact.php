<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    protected $fillable  = ['email', 'address', 'localisation', 'active', 'tel1', 'tel2', 'facebook', 'instagram', 'city', 'region', 'country'];
    protected $hidden   = ['created_at', 'updated_at'];
    protected $casts = [
        'localisation' => 'array',
    ];

    public function restau()
    {
        return $this->belongsTo('App\Model\Restau\Restau', 'rub_id');
    }

    public function acc()
    {
        return $this->belongsTo('App\Model\Acc\Acc', 'rub_id');
    }

    public function getActiveAttribute($active)
    {
        return (boolean) $active;
    }

    /**
     * [scopeSecureRestau description]
     * @param  int $id    Contact id
     * @return collection Contact Collection 
     */
    public function scopeSecureRestau($query, $limit, $id = null)
    {
        $contacts = Contact::join('restaus', 'restaus.id', 'contacts.rub_id')
                        ->where('restaus.user_id', Auth::user()->id)
                        ->where('contacts.rub_type', config('global.restau.id'))
                        ->limit( $limit );

        if( $id !== null )
        {
            return $contacts->where('contacts.id', $id)->first('contacts.*');
        }

        return $contacts->get('contacts.*');
    }
}
