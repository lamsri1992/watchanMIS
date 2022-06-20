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

Route::get('/','dashboard@index')->name('dashboard');

Route::group(['prefix' => 'person'], function () {
	Route::get('/people','person@gender');
});

Route::group(['prefix' => 'opd'], function () {
	Route::get('/refer','opd@opdRefer');
	Route::get('/refer/search','opd@searchRefer')->name('searchRefer');
	Route::get('/diag','opd@n10diag');
	Route::get('/diag/search','opd@searchDiag')->name('searchDiag');
});

Route::group(['prefix' => 'finance'], function () {
	Route::get('/report','finance@report')->name('searchFinance');
});