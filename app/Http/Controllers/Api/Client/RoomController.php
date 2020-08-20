<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ClientController;

use App\Model\Acc\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\Acc\Room;

class RoomController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($accId)
    {
        $acc  = Auth::user()->accs()
                            ->where('id', $accId)
                            ->first();

        if( empty($acc) )
        {
            $this->data['messages'] = 'Une erreur est survenue!!';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $this->data['data']['roomCategories'] = RoomCategory::orderBy('name')->get();

        $this->data['data']['rooms'] = Room::isSecure($accId);
        $this->data['data']['tarif'] = $acc->tarif();
        $this->data['data']['acc'  ] = $acc;

        return response()->json($this->data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($accId, Request $request)
    {
        $this->checkValidity($request);
        
        $acc  = Auth::user()->accs()
                            ->where(['id' => $accId])
                            ->first();

        if( empty($acc) )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $room = new Room( $request->all() );
        $room->acc_id = $accId;
        $room->save();

        $room->category; // show room category

        $this->data['messages']     = 'Enregistrement éffectuer.';
        $this->data['status']       = 'done';
        $this->data['data']['room'] = $room;

        return response()->json($this->data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($accId, $id)
    {
        $this->data['data']['room'] = Room::isSecure($accId, $id);
        return response()->json($this->data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($accId, Request $request, $id)
    {
        $this->checkValidity($request);
        $room = Room::isSecure($accId, $id);

        if( is_null($room) )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $room->update( $request->all());

        $this->data['messages'] = 'Enregistrement éffectuer.';
        $this->data['status']   = 'done';

        $this->data['data']['room'] = Room::with('category')->find($id);

        return response()->json($this->data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $accId, $id)
    {
        $room = Room::isSecure($accId, $id);

        if( is_null($room) )
        {
            $this->data['messages'] = 'Erreur lors de la suppression.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $this->data['status'] = $room->delete() ? 'done': 'failed';
        return response()->json($this->data, 200);
    }

    protected function checkValidity(Request $request)
    {
    }
}
