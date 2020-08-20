<?php

namespace App\Model\Acc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Model\Acc\Acc;
use App\Model\Contact;

class AccTarif extends Model
{
	public $timestamps  = false;
    protected $fillable = ['name', 'pictures', 'monthly', 'half_yearly', 'yearly', 'annexes', 'events'];
    protected $hidden   = ['created_at', 'updated_at'];

    public function makeRubriques($payment_id)
    {
        $userAccs    = Auth::user()->accs()->orderBy('id', 'DESC')->get();
    	$acc_to_make = $this->annexes + 1;

        Acc::whereIn('id', $userAccs->modelKeys())->update(['payment_id' => $payment_id]);

    	$accs = [];
        for ($i=count($userAccs); $i < $acc_to_make; $i++)
    	{
    		$acc = new Acc(['name' => 'H - '. Auth::user()->name]);
            $acc->active    = ($i == 0);
            $acc->principal = ($i == 0);
            $acc->user()->associate( Auth::id() );
            $acc->payment()->associate( $payment_id );
            $acc->save();

            $contact = new Contact();

            $contact->email    = Auth::user()->email;
            $contact->tel1     = Auth::user()->tel1;
            $contact->tel2     = Auth::user()->tel2;
            $contact->address  = Auth::user()->address;
            $contact->active   = true;
            $contact->rub_type = config('global.acc.id');

            $contact->acc()->associate( $acc );
            $contact->save();

            $accs[] = $acc;
        }

        if( count($userAccs) > $acc_to_make)
        {
            $deactivated = 0;
            foreach ($userAccs as $userAcc)
            {
                $userAcc->active = false;
                $userAcc->update(['active' => false]);

                $deactivated++;
                if( $deactivated == $acc_to_make)
                    break;
            }
        }

        // if( count($userAccs) > $acc_to_make )
        // {
        //     $deactivated = 0;
        //     foreach ($userAccs as $acc)
        //     {
        //         $acc->active = false;
        //         $acc->update();

        //         $deactivated++;
        //         if( $deactivated == $acc_to_make)
        //             break;
        //     }
        // }
        // else
        // {
        //     foreach ($userAccs as $acc)
        //     {
        //         $acc->active = true;
        //         $acc->update();
        //     }   
        // }

    	return $accs;
    }
}
