<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/core', [\App\Http\Controllers\CoreController::class, 'index'])->name('core');
Route::get('/config', [\App\Http\Controllers\CoreController::class, 'index'])->name('config');
Route::post('/config', [\App\Http\Controllers\CoreController::class, 'update'])->name('config.update');
