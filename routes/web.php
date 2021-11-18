<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ClubRoleController;
use App\Http\Controllers\ThreadController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/clubs', function () {
    return view('clubs.index');
})->name('clubs.index');

Route::resource('clubs', ClubController::class)
    ->middleware('auth');

Route::get('request', [ClubController::class, 'requestCreate'])
    ->middleware('auth')
    ->name('request.create');

Route::post('request', [ClubController::class, 'request'])
    ->middleware('auth')
    ->name('request.store');

Route::patch('clubs/{id}/roles', [UserRoleController::class, 'update'])
    ->middleware('auth')
    ->name('clubs.role.update');

Route::post('clubs/{id}/roles', [ClubRoleController::class, 'store'])
    ->middleware('auth')
    ->name('clubs.clubroles.store');

Route::get('clubs/{id}/roles/edit', [ClubRoleController::class, 'edit'])
    ->middleware('auth')
    ->name('clubs.clubroles.edit');

Route::patch('clubs/{id}/roles/edit', [ClubRoleController::class, 'update'])
    ->middleware('auth')
    ->name('clubs.clubroles.update');

Route::delete('clubs/{id}/roles/{clubrole}/edit', [ClubRoleController::class, 'destroy'])
    ->middleware('auth')
    ->name('clubs.clubroles.destroy');

Route::resource('clubs.plans', PlanController::class)
    ->middleware('auth')
    ->except('index');

Route::post('clubs/{club}/plans/{plan}/threads',[ThreadController::class, 'store'])
    ->middleware('auth')
    ->name('clubs.plans.threads.store');

Route::get('/clubs/{club}/{year}/{month}', [PlanController::class, 'index'])
    ->middleware('auth')
    ->name('clubs.plans.index');
