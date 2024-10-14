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

Route::get('/', \App\Livewire\Core\Welcome::class)->name('home');

Route::get('/config', \App\Livewire\Core\Setting::class)->name('config');
Route::get('/core', [\App\Http\Controllers\CoreController::class, 'index'])->name('core');
