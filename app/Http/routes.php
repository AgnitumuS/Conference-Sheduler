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

Route::get('/', 'EventController@index');

Route::auth();
Route::resource('event', 'EventController');
/*
Route::get('/home', 'HomeController@index');
Route::get('/event/{$id}', 'HomeController@view');
*/
Route::get('/ldap', function(){
  $events = Adldap::getDefaultProvider()->search()->users()->find('Вершков');;
  dd($events);
});
