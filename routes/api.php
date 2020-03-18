<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/B2CCallback','Callbacks@processB2CRequestCallback');
Route::post("/B2BCallback",'Callbacks@processB2BRequestCallback');
Route::post('/C2BValidation','Callbacks@processC2BRequestValidation');
Route::post('/C2BConfirmation','Callbacks@processC2BRequestConfirmation');
Route::post('/AccountBalCallback','Callbacks@processAccountBalanceRequestCallback');
Route::post('/ReversalCallback','Callbacks@processReversalRequestCallBack');
Route::post('/RequestStkCallback','Callbacks@processSTKPushRequestCallback');
Route::post('/QueryStkCallback','Callbacks@processSTKPushQueryRequestCallback');
Route::post('/TransStatCallback','Callbacks@processTransactionStatusRequestCallback');
