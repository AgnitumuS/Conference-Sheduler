<?php

use App\Event;

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

Route::auth();
Route::get('/', 'EventController@index');

Route::resource('event', 'EventController');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('room', 'RoomController');
    Route::get('settings', 'SettingsController@index');
    Route::post('settings', 'SettingsController@store');
    
    Route::get('ldap', function() {
        $a = Adldap::getDefaultProvider()->search()->users()->find('Вершков');
        dd($a);
    });
});
