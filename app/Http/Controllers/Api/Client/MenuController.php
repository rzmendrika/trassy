<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ClientController;

use App\Model\Restau\Menu;
use App\Model\Restau\Restau;
use App\Model\Restau\RestauPicture;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends ClientController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restau = Auth::user()->restau()->first(['id', 'name', 'payment_id']);

        if( empty($restau) )
        {
            $this->data['messages'] = 'Une erreur est survenue!!';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $tarif = $restau->tarif(); unset($restau->payment);

        $this->data['data']['menus' ] = Menu::isSecure($tarif->menus); // limiter les menus à recupérer
        $this->data['data']['tarif' ] = $tarif;
        $this->data['data']['restau'] = $restau;

        return response()->json($this->data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkValidity($request);        

        $restau = Auth::user()->restau;
        $tarif  = $restau->tarif();
        $menus  = $restau->menus()->count();

        if( empty($restau) || $menus >= $tarif->menus )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        $menu = new Menu( $request->all() );
        $menu->restau_id = $restau->id;
        $menu->save();

        if( $request->file('picture') )
        {
            $fileName = Str::slug($menu->name, '-') .'-'. uniqid() .'.'. $request->picture->extension();

            $request->file('picture')->storeAs('restaus/small/', $fileName, 'public');

            $picture = new RestauPicture([
                'path'     => $fileName,
                'type'     => Restau::MENU_ID,
                'child_id' => $menu->id,
            ]);
            
            $picture->restau()->associate($restau);
            $picture->save(); unset($picture->restau);
            
            $menu->picture = $picture;

            unset($picture->restau);
            unset($picture->parent_id);
            unset($picture->child_id);
        }

        $this->data['messages']     = 'Enregistrement éffectuer.';
        $this->data['status']       = 'done';
        $this->data['data']['menu'] = $menu;

        return response()->json($this->data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->checkValidity($request);

        $menu = Menu::isSecure(1, $id);

        if( is_null($menu) )
        {
            $this->data['messages'] = 'une erreur est survenue lors de l\' enregistrement.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }

        if( $request->file('picture') )
        {
            if( $menu->picture )
                $menu->picture->fullDelete();

            $fileName = Str::slug($menu->name, '-') .'-'. uniqid() .'.'. $request->picture->extension();

            $request->file('picture')->storeAs('restaus/small/', $fileName, 'public');

            $picture = new RestauPicture([
                'path'     => $fileName,
                'type'     => Restau::MENU_ID,
                'child_id' => $menu->id,
            ]);

            $picture->parent_id = $menu->restau_id;
            $picture->save();

            unset($picture->restau);
            unset($picture->parent_id);
            unset($picture->child_id);
            unset($menu->picture);            
        }

        $menu->update( $request->all() );
    
        if( $request->file('picture') )
            $menu->picture = $picture;
    
        $this->data['messages']     = 'Enregistrement éffectuer.';
        $this->data['status']       = 'done';
        $this->data['data']['menu'] = $menu;

        return response()->json($this->data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::isSecure(1, $id);

        if( is_null($menu) )
        {
            $this->data['messages'] = 'Erreur lors de la suppression.';
            $this->data['status']   = 'failed';
            return response()->json($this->data, 500);
        }
        
        if( $menu->picture )
        {
            $menu->picture->fullDelete();
        }

        $this->data['status'] = $menu->delete() ? 'done': 'failed';
        return response()->json($this->data, 200);
    }

    protected function checkValidity(Request $request)
    {
    }
}
