<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function home(){

        $folder = null;
        $files = File::whereNull('folder_id')->orWhere('folder_id', 0)->orderBy('created_at', 'desc');
        $folders = Folder::whereNull('parent_id')->orWhere('parent_id', 0)->orderBy('created_at', 'desc');

        $files = $files->paginate(10)->withQueryString();
        return view('index',compact('files','folders', 'folder'));
    }
}
