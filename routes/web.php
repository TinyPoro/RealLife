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


Route::get('/', function(){
    return redirect('/event/create');
});
Route::resource('event','EventController');

Route::get('/complete/{id}', 'EventController@complete')->name('event.complete');

Route::get('/info/{id}', 'EventController@getInfo')->name('info');

Route::post('/vote', 'EventController@vote')->name('vote');
