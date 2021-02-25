<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use \App\Http\Controllers\FileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;



Route::get('/', function () {
    return redirect('/home');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->middleware('guest')->name('password.update');

Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');
Route::get('/tags', [TagController::class, 'index'])->name('tags');

Route::resource('folder', 'FolderController')->middleware('auth');

Route::get('/file/filter', [FileController::class, 'filter'])->name('file.filter')->middleware('auth');
Route::get('/file/export', [FileController::class, 'export'])->name('file.export')->middleware('auth');
Route::get('/file/import', [FileController::class, 'importView'])->name('file.importView')->middleware('auth');
Route::post('/file/import', [FileController::class, 'import'])->name('file.import')->middleware('auth');

Route::resource('file', 'FileController')->middleware('auth');
Route::resource('user', 'UserController')->middleware('auth');

