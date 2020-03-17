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
Route::post('/B2CCallback','callbacks@processB2CRequestCallback');
Route::post("/B2BCallback",'callbacks@processB2BRequestCallback');
Route::post('/C2BValidation','callbacks@processC2BRequestValidation');
Route::post('/C2BConfirmation','callbacks@processC2BRequestConfirmation');
Route::post('/AccountBalCallback','callbacks@processAccountBalanceRequestCallback');
Route::post('/ReversalCallback','callbacks@processReversalRequestCallBack');
Route::post('/RequestStkCallback','callbacks@processSTKPushRequestCallback');
Route::post('/QueryStkCallback','callbacks@processSTKPushQueryRequestCallback');
Route::post('/TransStatCallback','callbacks@processTransactionStatusRequestCallback');
