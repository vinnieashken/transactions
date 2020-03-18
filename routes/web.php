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

Route::get('/','Login@index');
Route::get('/register/{shortcode}','Payments@register');
Route::get('/dashboard','Payments@index');
Route::get('/shortcode','Payments@shortcode');
Route::get('/services','Payments@services');
Route::post('/signin','Login@signin');
