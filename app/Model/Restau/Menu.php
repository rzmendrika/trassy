<?php

namespace App\Model\Restau;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $fillable = ['name', 'ingredients', 'price'];
    public $timestamps  = false;

    public function restau()
    {
    	return $this->belongsTo('App\Model\Restau\Restau');
    }

    public function picture()
    {
        return $this->hasOne('App\Model\Restau\RestauPicture', 'child_id')
                    ->where('type', Restau::MENU_ID);
    }

    public function user()
    {
        return $this->restau->user;
    }

    public function getPicture()
    {
        return $this->picture;
    }
    /**
     * [scopeIsSecure description]
     * @param  [type] $query [description]
     * @param  [type] $id    menu id
     * @return [type]        a menu with picture
     */
    public function scopeIsSecure($query, $limit = null, $id = null)
    {
        $conditions['users.id'] = Auth::user()->id;

        if( $id !== null )
        {
            $conditions['menus.id'] = $id;
        }

        $menu = Menu::join('restaus', 'restaus.id', '=', 'menus.restau_id')
                    ->join('users', 'users.id', '=', 'restaus.user_id')
                    ->where($conditions)
                    ->limit($limit)
                    ->with('picture');

        return ( $id == null ) ? $menu->get('menus.*') : $menu->first('menus.*');
    }
}
