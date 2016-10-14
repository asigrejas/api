<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::group(['prefix' => '/v1/churches/', 'namespace' => "Church\Http"], function () {
    Route::get('', 'ChurchController@all');

    Route::get('{id}', 'ChurchController@get')
        ->where('id', '[0-9]+');

    Route::post('', 'ChurchController@store');

/*
Route::match(['get', 'post'], 'search', 'ChurchController@search');
Route::delete('{id}', 'ChurchController@delete')
->where('id', '[0-9]+');

Route::match(['get', 'post'], '{id}/restore', 'ChurchController@restore')
->where('id', '[0-9]+');
 */
});
