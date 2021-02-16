<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Folder;

class HomeController extends Controller
{
    public function home(){
        $files = File::orderBy('created_at', 'desc')->get();
        $folders = Folder::orderBy('created_at', 'desc')->get();
        return view('index',compact('files','folders'));
    }
}
