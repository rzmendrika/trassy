<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group( function()
{
	Route::post('login'   , 'Api\AuthController@login');
	Route::get ('login'   , 'Api\AuthController@loggedOut')->name('login');
	Route::post('register', 'Api\AuthController@register');

	Route::get('logout', 'Api\AuthController@logout' )->middleware('auth:api');
	Route::get('user'  , 'Api\AuthController@getUser')->middleware('auth:api');

	Route::prefix('client')->name('client.')->namespace('Api\Client')->group(function ()
	{
	    Route::get('restaurants/tarifs' , 'RestauController@tarifs')->name('restau.tarif');
	    Route::get('hebergements/tarifs', 'AccController@tarifs'   )->name('acc.tarif');
	});

	Route::prefix('client')->name('client.')->middleware('auth:api')->namespace('Api\Client')->group(function ()
	{
	    // Hebergement
		Route::get   ('hebergements/images/{acc_id}'         , 'AccController@pictures'      )->name('acc.pic.index');
		Route::post  ('hebergements/images/{acc_id}'         , 'AccController@storePictures' )->name('acc.pic.store');
		Route::delete('hebergements/images/{acc_id}/{pic_id}', 'AccController@deletePictures')->name('acc.pic.delete');

		Route::resource('hebergements/{acc_id}/chambres', 'RoomController', ['names' => 'acc.room']);
		Route::resource('hebergements'                  , 'AccController' , ['names' => 'acc'   ]);

	    // Restaurant
		Route::get   ('restaurants/images'         , 'RestauController@pictures'      )->name('restau.pic.index');
		Route::post  ('restaurants/images'         , 'RestauController@storePictures' )->name('restau.pic.store');
		Route::delete('restaurants/images/{pic_id}', 'RestauController@deletePictures')->name('restau.pic.delete');

		
		Route::get('restaurants/contacts'     , 'RestauController@contacts'     )->name('restau.contact.index');
		Route::put('restaurants/contacts/{id}', 'RestauController@updateContact')->name('restau.contact.update');

		Route::resource('restaurants/menus', 'MenuController'  , ['names' => 'restau.menu']);
		Route::resource('restaurants'      , 'RestauController', ['names' => 'restau']);

	    // paiement
		Route::get ('paiements/{rub_type}/{rub_id}' , 'PaymentController@index' )->name('payment.index');
		Route::post('paiements/{rub_type}/{rub_id}' , 'PaymentController@store' )->name('payment.store');

	});

	Route::namespace('Api')->group(function ()
	{
		Route::get('restaurants'       , 'RestauController@index');
		Route::get('restaurants/search', 'RestauController@search');
		Route::get('restaurants/params', 'RestauController@params');
		Route::get('restaurants/{id}'  , 'RestauController@show');


		Route::get('hebergements'       , 'AccController@index');
		Route::get('hebergements/search', 'AccController@search');
		Route::get('hebergements/params', 'AccController@params');
		Route::get('hebergements/{id}'  , 'AccController@show');
	});
});
