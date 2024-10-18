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
Route::get('/newmod', \App\Livewire\NewMod::class)->name('newmod');
Route::get('/core', [\App\Http\Controllers\CoreController::class, 'index'])->name('core');
Route::get('/core/install-dependencies', \App\Livewire\InstallDependency::class)->name('install-dependencies');

Route::prefix('mod')->group(function () {
    Route::get('/selectMod', App\Livewire\Mod\SelectMod::class)->name('mod.select');
    Route::get('/selectMod/{modPath?}', App\Livewire\Mod\EditingMod::class)->name('mod.selected');
});
