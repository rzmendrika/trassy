<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Contact;
use App\Model\Restau\Restau;
use App\Model\Restau\RestauPicture;
use App\Model\Restau\RestauSpeciality;
use App\Model\Restau\RestauType;
use App\Model\Restau\RestauTarif;

class RestauController extends Controller
{
    protected $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['data'] = Restau::guestRestau()->paginate(10);
        return response( $this->data, 200);
    }

    public function search(Request $request)
    {
        $query =  Restau::guestRestau()->where('name', 'LIKE', '%'.$request->name.'%' );

        if( $request->parking == 1 )
            $query = $query->where('parking', 1);

        if( $request->weekend == 1 )
            $query = $query->openOnWeekend();

        if( $request->wifi == 1 )
            $query = $query->where('wifi', 1);

        if( $request->delivery == 1 )
            $query = $query->where('delivery', 1);

        if( $request->specialities )
            $query = $query->whereSpecialities($request->specialities);

        if( $request->types )
            $query = $query->whereTypes($request->types);

        // \DB::enableQueryLog();
        // return response( \DB::getQueryLog(), 200);

        $this->data['data'] = $query->paginate(10);

        return response( $this->data, 200);
    }

    public function params()
    {
        $this->data['data']['specialities'] = RestauSpeciality::all();
        $this->data['data']['types'] = RestauType::all();
        return response( $this->data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['data']['restau'] = Restau::guestRestau()->where('restaus.id', $id)
                                                             ->with('specialities', 'types', 'contacts', 'pictures', )
                                                             ->first();
        return response( $this->data, 200);
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
        //
    }
}
