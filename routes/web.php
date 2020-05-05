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
    // Dashboard
    Route::get('/classes', 'KlassController@index')->name('klass');
    Route::get('/tasks', 'TaskController@index');
    Route::get('/bills', 'BillController@index');
    Route::get('/schedules', 'KlassController@schedules_index');

    // Klass
    Route::get('/classes/create', 'KlassController@create')->name('klass.create');
    Route::get('/classes/{code}/edit', 'KlassController@edit')->name('klass.edit');
    Route::post('/classes/store', 'KlassController@store')->name('klass.store');

    // Klass > home
    Route::get('/classes/{code}', 'KlassController@show')->name('klass.show');
    Route::post('/classes/{id}/follow_subject', 'KlassController@follow_subject')->name('klass.follow_subject');
    Route::post('/classes/join', 'KlassController@join')->name('klass.join');
    Route::post('/classes/{id}/out', 'KlassController@out')->name('klass.out');
    Route::put('/classes/{code}/change_role', 'KlassController@change_role')->name('klass.change_role');
    Route::put('/classes/{code}/set_default_role', 'KlassController@set_default_role')->name('klass.set_default_role');
    Route::put('/classes/{id}/update', 'KlassController@update')->name('klass.update');
    Route::delete('/classes/{code}/kick', 'KlassController@kick')->name('klass.kick');
    Route::delete('/classes/{code}/ban', 'KlassController@ban')->name('klass.ban');
    Route::delete('/classes/{id}/destroy', 'KlassController@destroy')->name('klass.destroy');

    // Klass > task
    Route::get('/classes/tasks', 'TaskController@index')->name('task');
    Route::get('/classes/{klass_code}/tasks', 'TaskController@show')->name('task.show');
    Route::get('/classes/{klass_code}/tasks/create', 'TaskController@create')->name('task.create');
    Route::get('/tasks/{id}/edit', 'TaskController@edit')->name('task.edit');
    Route::post('/classes/{klass_id}/task/store', 'TaskController@store')->name('task.store');
    Route::put('/task/{id}/update', 'TaskController@update')->name('task.update');
    Route::delete('/tasks/{id}/destroy', 'TaskController@destroy')->name('task.destroy');

    // Klass > schedule
    Route::get('/classes/{code}/schedules', 'KlassController@schedules_show')->name('klass.schedules');
    Route::get('/classes/{klass_code}/schedules/create', 'KlassController@schedules_create')->name('klass.schedules_create');
    Route::post('/classes/{klass_id}/schedules/store', 'KlassController@schedules_store')->name('klass.schedules_store');
    Route::get('/classes/{id}/schedules/edit', 'KlassController@schedules_edit')->name('klass.schedules_edit');
    Route::put('/clases/{id}/schedules/update', 'KlassController@schedules_update')->name('klass.schedules_update');
    Route::delete('/classes/{id}/schedules/destroy', 'KlassController@schedules_destroy')->name('klass.schedules_destroy');

    // Klass > bill
    Route::get('/classes/bills', 'BillController@index')->name('bill');
    Route::get('/classes/{klass_code}/bills', 'BillController@show')->name('bill.show');
    Route::get('/classes/{klass_code}/bills/create', 'BillController@create')->name('bill.create');
    Route::post('/classes/{klass_id}/bills/store', 'BillController@store')->name('bill.store');
    Route::get('/bills/{id}/info', 'BillController@info')->name('bill.info');
    Route::get('/bills/{id}/edit', 'BillController@edit')->name('bill.edit');
    Route::post('/bills/{id}/update', 'BillController@update')->name('bill.update');
    Route::get('/bills/{id}/destroy', 'BillController@destroy')->name('bill.destroy');
    Route::get('/bills/{id}/{npm}/paid', 'BillController@paid')->name('bill.paid');
    Route::get('/bills/{paid_id}/{bill_id}/{npm}/unpaid', 'BillController@unpaid')->name('bill.unpaid');

});
