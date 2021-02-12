<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/file');
});

Route::get('/file/filter', '\App\Http\Controllers\FileController@filter')
        ->name('file.filter')->middleware('auth');;

Route::get('/file/export', '\App\Http\Controllers\FileController@export')
        ->name('file.export');

Route::resource('file', 'FileController')->middleware('auth');

Route::get('/home', function () {
    return redirect('/file');
});
