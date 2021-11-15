<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\PlanController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('clubs', ClubController::class)
    ->middleware('auth');

Route::resource('clubs.plans', PlanController::class)
    ->middleware('auth')
    ->except('index');

    Route::get('/clubs/{club}/{year}/{month}', [PlanController::class, 'index'])
    ->middleware('auth')
    ->name('clubs.plans.index');

