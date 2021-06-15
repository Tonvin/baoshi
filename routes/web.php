<?php

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

#Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');
#Route::get('/', [App\Http\Controllers\LinkController::class, 'main'])->middleware(['auth'])->name('index');
#Route::get('/dashboard', function () { return redirect('/home/dashboard'); });
Route::get('/', [App\Http\Controllers\LinkController::class, 'index'])->middleware(['auth'])->name('index');

require __DIR__.'/auth.php';

require __DIR__.'/link.php';
