<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PageController@landing');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/classes', 'KlassController@index')->name('klass');
    Route::get('/classes/create', 'KlassController@create')->name('klass.create');
    Route::get('/classes/{code}/edit', 'KlassController@edit')->name('klass.edit'); // TODO
    Route::get('/classes/{code}', 'KlassController@show')->name('klass.show');
    Route::get('/classes/{code}/tasks', 'KlassController@tasks')->name('klass.tasks');
    Route::get('/classes/{code}/schedules', 'KlassController@schedules')->name('klass.schedules');
    Route::get('/classes/{code}/bills', 'KlassController@bills')->name('klass.bills');
    Route::get('/tasks', 'TaskController@index');

    Route::post('/classes/store', 'KlassController@store')->name('klass.store');
    Route::post('/classes/join', 'KlassController@join')->name('klass.join');
    Route::post('/classes/{id}/out', 'KlassController@out')->name('klass.out'); // TODO
    Route::put('/classes/{code}/change_role', 'KlassController@change_role')->name('klass.change_role');
    Route::put('/classes/{code}/set_default_role', 'KlassController@set_default_role')->name('klass.set_default_role');
    Route::put('/classes/{id}/update', 'KlassController@update')->name('klass.update'); // TODO
    Route::delete('/classes/{id}/destroy', 'KlassController@destroy')->name('klass.destroy'); // TODO
    Route::delete('/classes/{code}/kick', 'KlassController@kick')->name('klass.kick');
    Route::delete('/classes/{code}/ban', 'KlassController@ban')->name('klass.ban');
});
