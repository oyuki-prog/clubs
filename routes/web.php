<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ClubRoleController;
use App\Http\Controllers\UserRoleController;
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

Route::get('request', [ClubController::class, 'requestCreate'])
    ->middleware('auth')
    ->name('request.create');

Route::post('request', [ClubController::class, 'request'])
    ->middleware('auth')
    ->name('request.store');

Route::get('clubs/{id}/members', [ClubRoleController::class, 'edit'])
    ->middleware('auth')
    ->name('clubs.members.edit');

Route::patch('clubs/{id}/members', [ClubRoleController::class, 'update'])
    ->middleware('auth')
    ->name('clubs.members.update');

Route::patch('clubs/{id}/role', [UserRoleController::class, 'update'])
    ->middleware('auth')
    ->name('clubs.role.update');

Route::resource('clubs.plans', PlanController::class)
    ->middleware('auth')
    ->except('index');

Route::get('/clubs/{club}/{year}/{month}', [PlanController::class, 'index'])
    ->middleware('auth')
    ->name('clubs.plans.index');
