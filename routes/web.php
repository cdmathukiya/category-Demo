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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('category')->group(function() {
	$categoryCntrl = 'CategoryController@';
	Route::get('/', $categoryCntrl.'index')->name('category');
    Route::post('/save', $categoryCntrl.'store');
    Route::get('/delete/{id}', $categoryCntrl.'destroy');
});
