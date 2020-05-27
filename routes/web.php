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
Route::get('/', 'Payments@index')->name('home');
Route::get('/register/{shortcode}','Payments@register');
Route::get('/dashboard','Payments@index');
Route::get('/shortcode','Payments@shortcode');
Route::get('/services','Payments@services');
Route::post('/signin','Login@signin');
Route::get('/transaction','Payments@transaction');
Route::post('/alltrans','Payments@alltrans');
Auth::routes();
Route::get('/home', 'Payments@index')->name('home');
Route::post('/saveshortcode','Payments@saveshortcode');
Route::post('/editshortcode','Payments@editshortcode');
Route::post('/notify', 'Payments@startnotification');
Route::post('/addservice','Payments@addservice');
Route::post('/editservice','Payments@editservice');
Route::get('/c2btest','Payments@c2btest');

Route::post('/app/c2bvalidation','Callbacks@C2BRequestValidation');
Route::post('/app/c2bconfirmation','Callbacks@processC2BRequestConfirmation');


