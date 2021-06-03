<?php

use Illuminate\Support\Facades\Route;

Route::get('/link/add', [App\Http\Controllers\LinkController::class, 'add'])->middleware(['auth'])->name('add');

Route::post('/link/insert', [App\Http\Controllers\LinkController::class, 'insert'])->middleware(['auth'])->name('insert');

Route::get('/link/list', [App\Http\Controllers\LinkController::class, 'list'])->name('list');

Route::get('/link/del/{id}', [App\Http\Controllers\LinkController::class, 'del'])->middleware(['auth'])->name('del');

Route::post('/link/select', [App\Http\Controllers\LinkController::class, 'select'])->name('select');
