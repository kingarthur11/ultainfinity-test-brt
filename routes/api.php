<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserAuthAPIController;
use App\Http\Controllers\API\UserbrtAPIController;

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


Route::controller(UserAuthAPIController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/brt/create', [UserbrtAPIController::class, 'store']);
    Route::get('/brt/{id}', [UserbrtAPIController::class, 'show']);
    Route::get('/brt', [UserbrtAPIController::class, 'index']);
    Route::put('/brt/{id}', [UserbrtAPIController::class, 'update']);
    Route::delete('/brt/{id}', [UserbrtAPIController::class, 'destroy']);
});


Route::get( '/unauthenticated', [UserAuthAPIController::class, 'unauthenticated'])->name('login');