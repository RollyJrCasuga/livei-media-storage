<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/file');
});

Route::resource('file', 'FileController');
