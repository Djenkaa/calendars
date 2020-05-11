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


Route::get('/', 'CompanyController@welcome')->name('company.welcome');
Route::get('/admin','CompanyController@index')->name('admin.index');


Route::prefix('calendar')->group(function () {

    Route::post('/store', 'CalendarController@store')->name('calendar.store');
    Route::get('/show/{calendar}', 'CalendarController@show')->name('calendar.show');
    Route::post('/reserve','CalendarController@reserve')->name('calendar.reserve');

    Route::post('/price', 'CalendarController@price')->name('calendar.price');

});


