<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Contact;
use App\Model\Acc\Acc;
use App\Model\Acc\AccPicture;
use App\Model\Acc\Room;
use App\Model\Acc\RoomCategory;
use App\Model\Acc\AccType;
use App\Model\Acc\AccTarif;

class AccController extends Controller
{
    protected $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['data'] = Acc::guestAcc()->paginate(10);
        return response( $this->data, 200);
    }

    public function search(Request $request)
    {
        $query =  Acc::guestAcc()->where('accs.name', 'LIKE', '%'.$request->name.'%' );

        if( $request->parking == 1 )
            $query = $query->where('parking', 1);

        if( $request->wifi == 1 )
            $query = $query->where('wifi', 1);

        if( $request->stars )
            $query = $query->where('stars', $request->stars);

        if( $request->types )
            $query = $query->whereTypes($request->types);

        // \DB::enableQueryLog();
        // return response( \DB::getQueryLog(), 200);

        $this->data['data'] = $query->paginate(10);

        return response( $this->data, 200);
    }

    public function params()
    {
        // $this->data['data']['rooms'] = RoomCategory::all();
        $this->data['data']['types'] = AccType::all();
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
        $this->data['data']['acc'] = Acc::guestAcc(true)->where('accs.id', $id)
                                                             ->with('types', 'contacts', 'pictures')
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
