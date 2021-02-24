<?php

namespace App\Http\Controllers;

use Spatie\Tags\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
        return response()->json([
            'tags' => Tag::all()->pluck('name')
        ]);
    }
}
