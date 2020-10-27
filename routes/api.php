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

Route::prefix('cargo')->group(function () {
    Route::get('/byid/{id}','ApiCargoControll@getById');
    
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('cargo/all','ApiCargoControll@getAll');
    Route::post('cargo','ApiCargoControll@create');
    Route::put('cargo/{id}','ApiCargoControll@update');
    Route::delete('cargo/{id}','ApiCargoControll@delete');
});


Route::prefix('pop')->group(function () {
    //CRUD
    Route::get('/byid/{id}', 'ApiPopControll@show');
    Route::put('/{id}', 'ApiPopControll@update');
    Route::delete('/{id}', 'ApiPopControll@destroy');
    Route::post('', 'ApiPopControll@store');

    Route::get('/historic/{id}', 'ApiPopHistoricController@index');
    Route::get('/historic/list/{id}', 'ApiPopHistoricController@list');

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

