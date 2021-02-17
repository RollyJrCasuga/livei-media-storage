<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use \App\Http\Controllers\FileController;



Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');
Route::get('/tags', [TagController::class, 'index'])->name('tags');


Route::resource('folder', 'FolderController')->middleware('auth');

Route::get('/file/filter', [FileController::class, 'filter'])->name('file.filter')->middleware('auth');

Route::get('/file/export', [FileController::class, 'export'])->name('file.export')->middleware('auth');
Route::resource('file', 'FileController')->middleware('auth');

