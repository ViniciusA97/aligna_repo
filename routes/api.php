<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/pops', 'ApiPopControll@get');
Route::get('/pops/list', 'ApiPopControll@list');
Route::get('/pops/selects', 'ApiPopControll@selects');

Route::prefix('pop')->group(function () {
    //CRUD
    Route::get('/byid/{id}', 'ApiPopControll@show');
    Route::put('/{id}', 'ApiPopControll@update');
    Route::delete('/{id}', 'ApiPopControll@destroy');
    Route::post('', 'ApiPopControll@store');

    Route::get('/edit/{id}', 'ApiPopControll@edit');
    Route::get('/data_create', 'ApiPopControll@create');
    
    Route::post('/duplicate/{id}', 'ApiPopControll@duplicate');
    Route::get('/pdf/{id}', 'ApiPopControll@pdf');
    Route::put('/version/{id}', 'ApiPopControll@version');

    //Create.
    // POP HISTORICS
});



Route::post('/login','TokenController@login')->name('login');
Route::post('/validate','TokenController@validateToken')->middleware('auth:api')->name('validate');
Route::post('/teste',function(Request $request){
    $url = $request->url();
    $urlFinal = str_replace('/api/teste','',$url);
    return response()->json(['url'=>$urlFinal]);
});

