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
	Route::get('/statement/{id}','finance@statement')->name('statement');
});

Route::group(['prefix' => 'visit'], function () {
	Route::get('/report','visit@report')->name('searchVisit');
});

Route::group(['prefix' => 'supplies'], function () {
	Route::get('/','supplies@index');
});

Route::group(['prefix' => 'report'], function () {
	Route::get('/','report@index')->name('report.index');
	Route::post('/getIcd10','report@getIcd10')->name('report.getIcd10');
	Route::get('/process','report@process')->name('report.process');
});

Route::group(['prefix' => 'todo'], function () {
	Route::get('/','todo@index');
	Route::get('/sendline','todo@sendline');
	Route::post('/sendData','todo@sendData')->name('sendData');
});

Route::group(['prefix' => 'claim'], function () {
	Route::get('/','claimlist@index')->name('claim.index');
	Route::get('/list','claimlist@list');
	Route::get('/confirm/{id}','claimlist@confirm')->name('claim.confirm');
	Route::get('/decline/{id}','claimlist@decline')->name('claim.decline');
});

Route::group(['prefix' => 'covid'], function () {
	Route::get('/','covidlist@index');
	Route::get('/process','covidlist@process')->name('covid.process');
});