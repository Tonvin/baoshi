<?php

use Illuminate\Support\Facades\Route;

Route::get('/link/add', [App\Http\Controllers\LinkController::class, 'add'])->middleware(['auth'])->name('add');

Route::post('/link/insert', [App\Http\Controllers\LinkController::class, 'insert'])->name('insert');
