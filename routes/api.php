<?php

use Illuminate\Http\Request;
use App\User;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('users', function(){
    return User::get();
});

Route::middleware(['auth:api', 'throttle:5,1'])->group(function () {
    Route::get('/add', 'CalculatorController@add');
    Route::get('/sub', 'CalculatorController@sub');
    Route::get('/div', 'CalculatorController@div');
    Route::get('/mul', 'CalculatorController@mul');
});

Route::post('/login', 'Auth\LoginController@login');


