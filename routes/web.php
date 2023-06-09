<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Log;
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
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/process', [DashboardController::class, 'process'])->name('file.process');
Route::post('/processWablas', [DashboardController::class, 'processWablas'])->name('file.processWablas');