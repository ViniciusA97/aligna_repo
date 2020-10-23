<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tenancy/new', 'Teste@online');
Route::get('/config', 'Teste@configOauth');
Route::get('/', 'LoginController@index')->name('default');
// Route::get('/login','LoginController@index');

Route::post('/teste','PopController@teste');
Route::get('/pops', 'PopController@index')->name('pop.index');// ok
Route::get('/pops/list', 'PopController@list')->name('pop.list');//ok
Route::prefix('pop')->group(function () {
    Route::get('create', 'PopController@create')->name('pop.create'); //ok
    Route::post('', 'PopController@store')->name('pop.store'); //ok

    Route::get('selects', 'PopController@selects')->name('pop.selects');//ok
    Route::get('edit/{id}', 'PopController@edit')->name('pop.edit');//ok
    Route::put('update/{id}', 'PopController@update')->name('pop.update');// ok

    Route::get('historic/{id}', 'PopHistoricController@index')->name('pop.historic');
    Route::get('historic/list/{id}', 'PopHistoricController@list')->name('pop.historiclist');
    Route::put('version/{id}', 'PopController@version')->name('pop.version');//ok
    Route::get('duplicate/{id}', 'PopController@duplicate')->name('pop.duplicate');//ok
    Route::get('pdf/{id}', 'PopController@pdf')->name('pop.pdf');//ok
    Route::get('{id}', 'PopController@show')->name('pop.show'); // ok 

    Route::delete('delete/{id}', 'PopController@destroy')->name('pop.delete');//ok
});

Route::prefix('upload')->group(function () {
    Route::post('', 'UploadController@store')->name('upload.store');
    Route::put('', 'UploadController@store')->name('upload.store');

    Route::delete('delete/{id}', 'UploadController@destroy')->name('upload.delete');
});

Route::get('/media/{path}', '\Hyn\Tenancy\Controllers\MediaController')
    ->where('path', '.+')
    ->name('tenant.media');

