<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller 
{
	public function register(Request $request)
	{
		$valider = Validator::make( $request->all(), 
			[ 
				'name'     => 'required',
				'email' => [
			        'required',
			        Rule::unique('users'),
			    ],
				'password' => 'required',
				'password_confirmation' => 'required|same:password',
			]
		);

		if ( $valider->fails() )
		{
			return response()->json(['success' => false, 'messages' => $valider->errors()], 401);
		}

		$input = $request->all();
		
		$input['password'         ] = Hash::make($input['password']);
        $input['email_verified_at'] = now();
        $input['remember_token'   ]	= Str::random(10);

		$user = User::create($input);

		return response()->json( ['success' => true, 'token' => $user->createToken('AppName')->accessToken ], 201);
	}

	public function login(Request $request)
	{
		$valider = Validator::make( $request->all(), 
			[ 
				'email'    => 'required|email',
				'password' => 'required',
			]
		);

		if ( $valider->fails() )
		{
			return response()->json(['success' => false, 'messages' => $valider->errors()], 401);
		}

		$isAuth = Auth::attempt( ['email' => $request->email, 'password' => $request->password] );

		if( $isAuth )
		{
			$user  = Auth::user();
			$token = $user->createToken('AppName')->accessToken;

			return response()->json(['success' => true, 'token' => $token], 200);
		}
		else
		{
			return response()->json(['success' => false, 'messages' => 'Unauthorized' ], 401); 
		} 
	}

	public function getUser()
	{
		$user = Auth::user();
		return response()->json(['success' => true, 'data' => ['user' => $user]], 200); 
	}

	public function logout(Request $request)
	{
		$user = $request->user('api')->token()->revoke();
		return response()->json(['success' => true, 'messages' => 'logged out'], 200);
	}

	public function loggedOut()
	{
		return response()->json(['success' => true, 'messages' => 'Unauthorized'], 401); 
	}

}