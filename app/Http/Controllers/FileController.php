<?php

namespace App\Http\Controllers;

use App\Models\File;
use Spatie\Tags\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileStorage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
        $tags = Tag::all();
        return view('file.index',compact('files','tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('file.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        
        $file_name = $request->file('file')->getClientOriginalName();
        $mime_type = $request->file->getClientMimeType();
        $file_size = $request->file('file')->getSize();
        $file_size = number_format($file_size / 1048576,2)."MB";


        if ($request->get('name')) {
            $file_name = $request->get('name');
            $file_type = $request->file('file')->extension();
            $file_name = $file_name . '.' . $file_type;
        }

        $request->file->move(public_path('media/'.'user'), $file_name);
        $file_path = '/media/' . 'user/' . $file_name;

        $file = File::create(['name' => $file_name,
        'mime_type' => $mime_type,
        'file_path' =>  $file_path,
        'file_size' => $file_size,
        ]);

        if ($request->tags) {
            $tags = $this->decodeTag($request->tags);
            $file->attachTags($tags);
        }
        
        return redirect()->route('file.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        $tags = Tag::all();
        return view('file.edit', compact('file','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $file_name = $request->get('name');
        $old_path = $file->file_path;
        $new_path = '/media/' . 'user/' . $file_name;

        FileStorage::move(public_path($old_path), public_path($new_path));
        $file->update(['name' => $file_name, 
        'file_path' => $new_path
        
        ]);

        $tags = [];
        if ($request->tags) {
            $tags = $this->decodeTag($request->tags);
        }
        
        $file->syncTags($tags);
        return redirect()->route('file.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if(file_exists(public_path().$file->file_path)){
            unlink(public_path().$file->file_path);
        }
        $file->delete();
        return redirect()->route('file.index');
    }

    public function decodeTag($tags){
        $decoded_tags = [];
        $init_tags = json_decode($tags, true);
        for ($i=0; $i<count($init_tags); $i++) {
            $decoded_tags[$i] = $init_tags[$i]['value'];
        }
        return $decoded_tags; 
    }
}
