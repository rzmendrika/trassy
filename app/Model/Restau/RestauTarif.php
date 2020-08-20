<?php

namespace App\Model\Restau;

use App\Model\Restau\Restau;
use App\Model\Contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RestauTarif extends Model
{
	public $timestamps  = false;
    protected $fillable = ['name', 'pictures', 'menus', 'monthly', 'half_yearly', 'yearly', 'localisations', 'events'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function makeRubriques($payment_id)
    {
        $restau   = Auth::user()->restau;

        if(empty($restau))
        {
    		$restau = new Restau(['name' => 'Resto - '. Auth::user()->name]);
            $restau->user()->associate( Auth::id() );
        }

        $restau->payment()->associate( $payment_id );
        $restau->save();

        $contacts = $restau->contacts;
        for ($i= count($contacts); $i < $this->localisations; $i++)
        { 
            $contact = new Contact();

            $contact->email    = Auth::user()->email;
            $contact->tel1     = Auth::user()->tel1;
            $contact->tel2     = Auth::user()->tel2;
            $contact->address  = Auth::user()->address;
            $contact->rub_type = config('global.restau.id');
            $contact->rub_id   = $restau->id;

            if($i == 0) $contact->active = true;
            
            $contact->save();
        }

    	return [$restau];
    }
}
