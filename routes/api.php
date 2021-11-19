<?php

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ThreadController;
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

// ユーザー登録
Route::post('/register', [RegisterController::class, 'register']);

// ログイン
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => ['api']], function(){
    Route::apiResource('clubs', ClubController::class)
        ->middleware('auth:sanctum');

    Route::apiResource('clubs.plans', PlanController::class)
        ->middleware('auth:sanctum')
        ->except('index');

    Route::post('request', [ClubController::class, 'request'])
    ->middleware('auth:sanctum')
    ->name('request.store');

    Route::post('clubs/{club}/plans/{plan}/threads', [ThreadController::class, 'store'])
        ->middleware('auth:sanctum')
        ->name('clubs.plans.threads.store');

    Route::get('/clubs/{club}/{year}/{month}', [PlanController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('clubs.plans.index');
});
