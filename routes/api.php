<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckScope;
use App\Http\Middleware\UpdateLastAsccess;

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


Route::get('/pops', 'ApiPopControll@get');
Route::get('/pops/list', 'ApiPopControll@list');
Route::get('/pops/selects', 'ApiPopControll@selects');

Route::post('/member/confirmAccount','ApiUserControll@confirmAccount');
Route::post('/member/resetPassword','ApiUserControll@resetPassword');
Route::post('/member/createPassword','ApiUserControll@confirmNewPassword');
    

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('cargo')->group(function () {
    Route::get('/byid/{id}','ApiCargoControll@getById'); 
});

Route::group(['middleware' => ['auth:api',UpdateLastAsccess::class]], function () {
     
    Route::get('cargo','ApiCargoControll@getAll');
    Route::get('cargo/{id}','ApiCargoControll@getById');
    Route::get('cargo/users/{id}','ApiCargoControll@getAllUserById');
    
    Route::get('setor','ApiSetorControll@getAll');
    Route::get('setor/{id}','ApiSetorControll@getById');
    Route::get('setor/users/{id}','ApiSetorControll@getAllUserById');
    
    Route::get('member','ApiUserControll@getAll');
    Route::get('member/{id}','ApiUserControll@getById');
    
    Route::middleware([CheckScope::class])->group(function () {
        
        Route::post('cargo','ApiCargoControll@create');
        Route::put('cargo/{id}','ApiCargoControll@update');
        Route::delete('cargo/{id}','ApiCargoControll@delete');
       
        Route::post('setor','ApiSetorControll@create');
        Route::put('setor/{id}','ApiSetorControll@update');
        Route::delete('setor/{id}','ApiSetorControll@delete');

        Route::post('member/accessible','ApiUserControll@createWithEmail');
        Route::post('member/not-accessible','ApiUserControll@createWithOutEmail');
        Route::post('member/{id}','ApiUserControll@update');
        Route::delete('member/{id}','ApiUserControll@delete');

        Route::post('upload','UploadController@store');
        Route::delete('upload/{id}','UploadController@destroy');

    });

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
    
    Route::get('upload','UploadController@all');
});

Route::post('/login','TokenController@login')->name('login');
Route::post('/validate','TokenController@validateToken')->middleware('auth:api')->name('validate');
Route::post('/teste',function(Request $request){
    $url = $request->url();
    $urlFinal = str_replace('/api/teste','',$url);
    return response()->json(['url'=>$urlFinal]);
});