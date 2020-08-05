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

Route::get('/', 'MainController@index');

Route::group(['prefix' => '/navigation', 'as' => 'nav.'], function() {
    Route::get('/manual/{configuration}',['as' => 'manual', 'uses' => 'ManualNavController@show']);
});
