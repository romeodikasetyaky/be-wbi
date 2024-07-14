<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RouteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/testing', [AuthController::class, 'tw']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/nar1', [RouteController::class, 'store_nar1']);
Route::get('/area-nar1', [RouteController::class, 'getNarSatu']);
Route::get('/nar1/{id}', [RouteController::class, 'getDetailsNarSatu']);


Route::post('/nar1a', [RouteController::class, 'store_nar1a']);
Route::get('/area-nar1a', [RouteController::class, 'getNarSatuA']);
Route::get('/nar1a/{id}', [RouteController::class, 'getDetailsNarSatuA']);

Route::post('/rec1', [RouteController::class, 'store_rec1']);
Route::get('/area-rec1', [RouteController::class, 'getRecSatu']);
Route::get('/rec1/{id}', [RouteController::class, 'getDetailsRecSatu']);