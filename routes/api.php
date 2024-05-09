<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware('api')->namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::prefix('user')->middleware('api')->namespace('App\Http\Controllers')->group(function () {
    Route::get('index', 'UserController@index')->middleware('jwt.auth', 'checkUserRole:super');
    Route::get('show/{id}', 'UserController@show')->middleware('jwt.auth', 'CheckUserOrRole:super');
    Route::post('store', 'UserController@store');
    Route::put('update/{id}', 'UserController@update')->middleware('jwt.auth', 'CheckUserOrRole:super');
    Route::delete('delete/{id}', 'UserController@delete')->middleware('jwt.auth', 'checkUserRole:super');
});

Route::prefix('transfer')->middleware('api')->namespace('App\Http\Controllers')->group(function () {
    Route::post('/', 'TransferController@transfer')->middleware('jwt.auth', 'CheckIsForbiddenUser:shopkeeper');
    Route::delete('cancel/{id}', 'TransferController@cancel')->middleware('jwt.auth', 'checkUserRole:super');
});

Route::prefix('wallet')->middleware('api')->namespace('App\Http\Controllers')->group(function () {
    Route::get('show/{id}', 'WalletController@show')->middleware('jwt.auth', 'CheckUserOrRole:super');
    Route::post('withdrawal/{id}', 'WalletController@withdrawal')->middleware('jwt.auth', 'CheckUserOrRole:super');
    Route::post('deposit/{id}', 'WalletController@deposit')->middleware('jwt.auth', 'CheckUserOrRole:super');
});
