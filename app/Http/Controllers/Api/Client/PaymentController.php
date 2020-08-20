<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Acc\AccTarif;
use App\Model\Restau\RestauTarif;
use App\Model\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected $data = array();

    /**
     * Go to payment form
     * @param  int $rub_type  (restau, acc, ...)
     * @param  int $tarif_id  tarif id
     * @return view           view
     */
    public function index($rub_type, $tarif_id)
    {
        switch ($rub_type) 
        {
            case config('global.acc.id'):
                $tarif = AccTarif::find($tarif_id);
                break;

            case config('global.restau.id'):
                $tarif = RestauTarif::find($tarif_id);
                break;
            
            default:
                return response()->json($this->data, 500);
                break;
        }

        $this->data['data']['rub_type'] = $rub_type;
        $this->data['data']['tarif']    = $tarif;

        return response()->json($this->data, 200);
    }

    public function store(Request $request, $rub_type, $tarif_id)
    {
        switch ($rub_type)
        {
            case config('global.acc.id'):
                $tarif = AccTarif::find($tarif_id);
                break;

            case config('global.restau.id'):
                $tarif = RestauTarif::find($tarif_id);
                break;
            
            default:
                return response()->json($this->data, 500);
                break;
        }

        if ( empty($tarif) ) 
            return response()->json($this->data, 500);

        $duration = ($request->type == 3) ? 12 : 1;
        $duration = ($request->type == 2) ? 06 : 1;

        $payment = Payment::create([
            'tarif_id'     => $tarif->id,
            'user_id'      => Auth::user()->id,
            'subscription' => $request->get('type'), // annuel, mensuel, semestriel
            'mode'         => $request->get('mode'), // MVOLA, OrangeMoney, ...
            'reference'    => uniqid(), // $request->get('ref'),
            'ending'       => Carbon::now()->add($duration, 'month'),
            'rub_type'     => $rub_type,
        ]);

        $tarif->makeRubriques($payment->id);
        session(['tarif' => null ]); // reinitialise le tarif

        $this->data['status']        = 'done';
        $this->data['data']['tarif'] = $tarif;
        return response()->json($this->data, 200);
    }
}
