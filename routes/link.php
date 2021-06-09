<?php

use Illuminate\Support\Facades\Route;

Route::get('/link/add', [App\Http\Controllers\LinkController::class, 'add'])->middleware(['auth'])->name('add');

Route::post('/link/insert', [App\Http\Controllers\LinkController::class, 'insert'])->middleware(['auth'])->name('insert');

Route::get('/link/list', [App\Http\Controllers\LinkController::class, 'list'])->name('list');

Route::get('/link/del/{id}', [App\Http\Controllers\LinkController::class, 'del'])->middleware(['auth'])->name('del')->where('id', '[0-9]+');

Route::get('/link/edit/{id}', [App\Http\Controllers\LinkController::class, 'edit'])->middleware(['auth'])->name('edit')->where('id', '[0-9]+');

Route::post('/link/select/{name}', [App\Http\Controllers\LinkController::class, 'select'])->name('select');

Route::post('/link/update', [App\Http\Controllers\LinkController::class, 'update'])->middleware(['auth'])->name('update');

Route::get('/user/{name}/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

Route::get('/user/{name}/page/{page}', [App\Http\Controllers\LinkController::class, 'page'])->name('page');
