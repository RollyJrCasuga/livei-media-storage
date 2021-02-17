<?php

namespace App\Http\Controllers;

use Spatie\Tags\Tag;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileStorage;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $folder_id = $request->get('folder_id');
        return view('folder.create', compact('folder_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder_name = $request->get('name');
        $parent_id = $request->get('parent_id');
        
        if ($parent_id) {
            $parent_folder = Folder::firstWhere('id', $parent_id);
            $folder_path = $parent_folder->folder_path . $folder_name . '/';
        } else {
            $user = auth()->user()->first_name;
            $folder_path = '/media/'. $user . '/' . $folder_name . '/';
        }

        $create_path = public_path($folder_path);
        if(!FileStorage::isDirectory($create_path)){
            FileStorage::makeDirectory($create_path, 0777, true, true);
        }

        $folder = Folder::create([
            'name' => $folder_name,
            'folder_path' =>  $folder_path,
            'parent_id' => $parent_id,
        ]);
        
        return redirect()->route('folder.show', $folder->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    { 
        $files = $folder->files;
        $folders = $folder->subfolder;
        return view('folder.index', compact('folder', 'files', 'folders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder_path = $folder->folder_path;
        if (auth()->user()->hasRole('administrator')){
            foreach ($folder->files as $file) {
                $file->delete();
            }
            foreach ($folder->children as $folder) {
                foreach ($folder->files as $file) {
                    $file->delete();
                }
                $folder->delete();
            }
            $folder->delete();
            FileStorage::deleteDirectory($folder_path);
            return redirect()->route('home');
        }
        else{
            session()->flash('alert-class', 'danger');
            session()->flash('message', 'Permission Denied!');
            return redirect()->back();
        }
    }
}
