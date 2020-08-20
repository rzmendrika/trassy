<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ClientController;

use App\Model\Acc\Acc;
use App\Model\Acc\AccType;
use App\Model\Acc\AccPicture;
use App\Model\Acc\AccTarif;
use App\Model\Acc\RoomCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccController extends ClientController
{

    public function __construct()
    {
        $this->data['sideBar'] = 'acc';
        $this->data['data']['rub'] = config('global.acc.id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accs = Auth::user()->accs()
                            ->join('contacts', 'contacts.rub_id', 'accs.id')
                            ->where('contacts.rub_type', 2)
                            ->get(['accs.id', 'accs.name', 'accs.active', 'accs.payment_id', 'accs.principal', 'contacts.city']);

        if( empty($accs) || $accs->count() == 0 )
        {
            return response()->json($this->data, 403);        
        }

        $this->data['data']['accs' ] = $accs;
        $this->data['data']['tarif'] = $accs[0]->tarif();

        unset($accs[0]->payment);

        return response()->json($this->data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['data']['acc'     ]       = Acc::secure($id);
        $this->data['data']['accTypes']       = AccType::orderBy('name')->get();
        $this->data['data']['RoomCategories'] = RoomCategory::orderBy('name')->get();

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

        $acc = Auth::user()->accs()->where(['id' => $id])->first(); //Acc::find($id);

        if( empty($acc) )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        if($request->active == 1 && $request->name === null)
        {
            $actives = Auth::user()->accs()->where('active', true)->count();
            if( $actives >= $acc->tarif()->annexes && !boolval($acc->active) )
            {
                $this->data['messages'] = 'Pour éffectuer cette opération, vous devez changer de tarif. Merci!';
                $this->data['status']   = 'failed';
                return response()->json($this->data, 403);
            }
            else
            {
                if( !boolval($request->principal) )
                {
                    $acc->active = !boolval($acc->active); 
                    $acc->update();
                    $this->data['status']   = 'done';
                    $this->data['data'  ]   = $acc->active;
                    return response()->json($this->data, 200);
                }
                else
                {
                    $this->data['messages'] = 'Vous ne pouvez pas désactiver l\'annexe principal.';
                    $this->data['status']   = 'failed';
                    return response()->json($this->data, 403);
                }
            }
        }

        Auth::user()->accs()->update(['name' => $request->get('name')]);
        $acc->contact->update( $request->get('contact') );
        $acc->update( $request->all() );
        $acc->types()->sync( $request->get('types') );

        $this->data['messages']    = 'Enregistrement éffectuer.';
        $this->data['status']      = 'done';
        $this->data['data']['acc'] = $acc;

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
        $acc = Auth::user()->accs()->where(['id' => $id])->first(); //Acc::find($id);
        if( empty($acc) && !$request->ajax() )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $acc->delete();
            $this->data['status'] = 'done';
            return response()->json($this->data, 200);
        }
    }


    public function pictures($acc_id)
    {
        $acc = Auth::user()->accs()->where(['id' => $acc_id])->first(); //Acc::find($id);

        if( empty($acc) )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $rubriques = [];
        $roomPics  = [];

        $description = [
            'title'    => 'Déscription du lieu',
            'type'     => Acc::DESCRIPTION_ID,
            'pictures' => $acc->descriptionPictures(),
            'id'       => 'speciality',
            'child_id' => '',
        ];
        $rubriques[] = $description;

        foreach ($acc->roomPictures() as $pic)
        {
            $roomPics[$pic->child_id][] = $pic;
        }

        $rooms = [];
        foreach ($acc->rooms as $room)
        {
            $r = [
                'title'    => $room->category->name .' - '. $room->bed_numbers . "Lit(s)",
                'type'     => Acc::ROOM_ID,
                'pictures' => isset($roomPics[ $room->id ]) ? $roomPics[ $room->id ] : [],
                'id'       => 'room-' . $room->id,
                'child_id' => $room->id,
            ];
            $rooms[] = $r;
        }
        $rubriques[] = [
            'title' => 'Chambres',
            'data'  => $rooms,
        ];

        $this->data['data']['max'] = $max  = $acc->tarif()->pictures;
        $this->data['data']['now'] = $now  = min($max, $acc->pictures()->count());
        $this->data['data']['rubriques']   = $rubriques;
        $this->data['data']['route']       = route('client.acc.pic.store', $acc->id);

        return response()->json($this->data, 200);
    }

    public function storePictures($acc_id, Request $request)
    {
        $this->validate($request, [
            'small'  => 'required|image|mimes:jpeg,png,jpg|max:600',
            'large' => 'required|image|mimes:jpeg,png,jpg|max:600',
            'type'   => 'required|integer',
        ]);

        $acc = Auth::user()->accs()->where(['id' => $acc_id])->first();

        if( empty($acc) )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $max = $acc->tarif()->pictures;
            $now = $acc->pictures()->count();
            
            if( $max <= $now )
            {
                $this->data['status']     = 'failed';
                $this->data['messages'][] = 'Unautorized';
                return response()->json($this->data, 403);
            }
            else
            {
                $fileName = Str::slug($acc->name, '-') .'-'. uniqid() .'.'. $request->large->extension();

                $request->file('large')->storeAs('accs/large/', $fileName, 'public');
                $request->file('small')->storeAs('accs/small/', $fileName, 'public');

                $picture = new AccPicture([
                    'path'    => $fileName,
                    'type'    => $request->get('type'),
                    'child_id'=> $request->get('id'),
                ]);
                
                $picture->acc()->associate($acc);
                $picture->save(); unset($picture->acc);

                $this->data['status']          = 'done';
                $this->data['data']['picture'] = $picture;
                return response()->json($this->data, 200);
            }
        }
    }

    public function deletePictures($acc_id, $pic_id)
    {
        $acc = Auth::user()->accs()
                           ->where(['id' => $acc_id])
                           ->first();
        
        if( empty($acc) && !$request->ajax() )
        {
            $this->data['status'] = 'failed';
            return response()->json($this->data, 500);
        }
        else
        {
            $pic = $acc->pictures()->where(['id' => $pic_id])->first();
            $pic->fullDelete();
            
            $this->data['status'] = 'done';
            return response()->json($this->data, 200);
        }
    }

    public function tarifs()
    {
        $this->data['data']['tarifs'] = AccTarif::all();
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
