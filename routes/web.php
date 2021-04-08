<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\WalletsController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::post('/recharge-balance', [WalletsController::class, 'recharge'])
    ->middleware(['auth'])
    ->name('recharge-balance');

Route::get('/deposits', [DepositsController::class, 'index'])
    ->middleware(['auth'])
    ->name('deposits');

Route::post('/deposits/recharge', [DepositsController::class, 'recharge'])
    ->middleware(['auth'])
    ->name('recharge-deposit');

require __DIR__ . '/auth.php';
