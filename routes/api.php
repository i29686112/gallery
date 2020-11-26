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

Route::get('/cookie/set', function (Request $request) {

    setcookie('secret','@#$%^&*',0,'','',false,true);
    return 'set ok';
});

Route::get('/cookie/get', function (Request $request) {
    return "secret is ". (isset($_COOKIE['secret'])?$_COOKIE['secret']:'');
});


