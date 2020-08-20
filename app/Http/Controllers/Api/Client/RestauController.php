<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ClientController;

use App\Model\Contact;
use App\Model\Restau\Restau;
use App\Model\Restau\RestauPicture;
use App\Model\Restau\RestauSpeciality;
use App\Model\Restau\RestauType;
use App\Model\Restau\RestauTarif;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestauController extends ClientController
{
    protected $data;

    public function __construct(Request $request)
    {
        $this->data['sideBar'] = 'restau';
        $this->data['data']['rub'] = config('global.restau.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restau = Auth::user()->restau;

        if( empty($restau) )
        {
            $this->data['messages'] = 'Aucun restaurant.';
            $this->data['status']   = 'failed';

            return response()->json($this->data, 403);
        }

        $_types = [];
        foreach ($restau->types as $type) {
            $_types[] = $type->id;
        }

        $_specialities = [];
        foreach ($restau->specialities as $speciality) {
            $_specialities[] = $speciality->id;
        }

        unset($restau->types);
        unset($restau->specialities);

        $restau->types = $_types;
        $restau->specialities = $_specialities;

        $this->data['data']['restau'] = $restau;
        $this->data['data']['tarif' ] = $restau->tarif();

        $this->data['data']['types']        = RestauType::orderBy('name')->get();
        $this->data['data']['specialities'] = RestauSpeciality::orderBy('name')->get();

        return response()->json($this->data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->checkValidity($request);

        $restau = Auth::user()->restau;

        if( empty($restau) )
        {
            $this->data['messages'] = 'Une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }
        
        $restau->update( $request->all() );
        $restau->types()->sync( $request->get('types') );
        $restau->specialities()->sync( $request->get('specialities') );

        $this->data['messages'] = 'Enregistrement éffectuer.';
        $this->data['status']   = 'done';
        $this->data['data']['restau'] = $restau;

        return response()->json($this->data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $restau = Auth::user()->restau;
        if( empty($restau) )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $restau->delete();
            $this->data['status'] = 'done';
            return response()->json($this->data, 200);
        }
    }

    public function pictures()
    {
        $restau = Auth::user()->restau;

        if( empty($restau) )
        {
            $this->data['messages'] = 'Unauthorized';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 403);
        }

        $rubriques = [];
        $roomPics  = [];

        $description = [
            'title'    => 'Déscription du lieu',
            'type'     => Restau::DESCRIPTION_ID,
            'pictures' => $restau->descriptionPictures(),
            'id'       => 'description',
            'child_id' => '',
        ];
        $rubriques[] = $description;

        $speciality = [
            'title'    => 'Spécialités',
            'type'     => Restau::SPECIALITY_ID,
            'pictures' => $restau->specialityPictures(),
            'id'       => 'speciality',
            'child_id' => '',
        ];
        $rubriques[] = $speciality;

        $parking = [
            'title'    => 'Parking',
            'type'     => Restau::PARKING_ID,
            'pictures' => $restau->parkingPictures(),
            'id'       => 'parking',
            'child_id' => '',
        ];
        $rubriques[] = $parking;

        $this->data['data']['max'] = $max  = $restau->tarif()->pictures;
        $this->data['data']['now'] = $now  = min($max, $restau->pictures()->count());
        $this->data['data']['rubriques']   = $rubriques;
        $this->data['data']['route']       = route('client.restau.pic.store');
        $this->data['data']['parentRoute'] = route('client.restau.index'    );
        $this->data['data']['cloudinary']  = $this->initCloudinary($max - $now);

        return response()->json($this->data, 200);
    }

    public function contacts()
    {
        $contacts = Contact::secureRestau( Auth::user()->restau->tarif()->localisations );

        $this->data['data']['contacts'] = $contacts;
        $this->data['status']           = 'done';

        return response()->json($this->data, 200);
    }

    public function updateContact(Request $request, $id)
    {
        $contact = Contact::secureRestau(1, $id);
        if( empty($contact) )
        {
            $this->data['messages'] = 'Une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        if( $request->activate )
        {
            $contact->update( ['active' => !$contact->active] );
        }
        else
        {
            $contact->update( $request->all() );
        }

        $this->data['messages'] = 'Enregistrement éffectuer.';
        $this->data['status']   = 'done';
        $this->data['data']['contact'] = $contact;

        return response()->json($this->data, 200);
    }

    public function storePictures(Request $request)
    {
        $this->validate($request, [
            'small'  => 'required|image|mimes:jpeg,png,jpg|max:600',
            'large' => 'required|image|mimes:jpeg,png,jpg|max:600',
            'type'   => 'required|integer',
        ]);

        $restau = Auth::user()->restau;

        if( empty($restau) )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $max = $restau->tarif()->pictures;
            $now = $restau->pictures()->where('child_id', '<>', Restau::MENU_ID)->count();
            
            if( $max <= $now )
            {
                $this->data['status']     = 'failed';
                $this->data['messages'][] = 'Unautorized';
                return response()->json($this->data, 403);
            }
            else
            {
                $fileName = Str::slug($restau->name, '-') .'-'. uniqid() .'.'. $request->large->extension();

                $request->file('large')->storeAs('restaus/large/', $fileName, 'public');
                $request->file('small')->storeAs('restaus/small/', $fileName, 'public');

                $picture = new RestauPicture([
                    'path'    => $fileName,
                    'type'    => $request->get('type'),
                    'child_id'=> $request->get('id'),
                ]);

                $picture->restau()->associate($restau);
                $picture->save(); unset($picture->restau);

                $this->data['status']          = 'done';
                $this->data['data']['picture'] = $picture;
                return response()->json($this->data, 200);
            }
        }
    }
    
    public function deletePictures($pic_id)
    {
        $restau = Auth::user()->restau;
        
        if( empty($restau) && !$request->ajax() )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $pic = $restau->pictures()->where(['id' => $pic_id])->first();
            $pic->fullDelete();
            
            $this->data['status'] = 'done';
            return response()->json($this->data, 200);
        }
    }

    public function tarifs()
    {
        $this->data['data']['tarifs'] = RestauTarif::all();
        $this->data['status']         = 'done';

        return response()->json($this->data, 200);
    }

    protected function checkValidity(Request $request)
    {
        for ($i=0; $i<10; $i++)
        {
            $to_validate[ 'pic_' . $i ] = 'image|mimes:jpeg,png,jpg,gif,svg|max:600';
        }
        return $this->validate($request, $to_validate);
    }
}
