<?php

namespace App\Http\Controllers;

use App\Models\File;
use Spatie\Tags\Tag;
use App\Models\Folder;
use App\Exports\MainExport;
use App\Imports\MainImport;
use App\Exports\FilesExport;
use App\Imports\FilesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
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
        $files = File::orderBy('created_at', 'desc')->get();
        return view('file.index',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $folder_id = $request->get('folder_id');
        return view('file.create', compact('folder_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|max:15000000',
            'files.*' => 'mimes:mp4,jpeg,jpg,png'
        ]);
        
        
        if ($validator->fails()) {
            session()->flash('alert-class', 'danger');
            session()->flash('message', 'File not supported. Note: Maximum upload size is 15GB');
            return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
        }

        if(!($request->tags)){
            session()->flash('alert-class', 'danger');
            session()->flash('message', 'Please add tags. Note: File resolution tags is mandatory (ex. 4k, 8k etc.)');
            return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
        }

        if(auth()->user()->hasRole('youtube')){
            $root_folder = 'youtube';
        }
        elseif(auth()->user()->hasRole('accounting')){
            $root_folder = 'acounting';
        }

        $folder_id = $request->get('folder_id');

        if($files = $request->file('files'))
        {
            if ($folder_id) {
                $parent_folder = Folder::firstWhere('id', $folder_id);
                $folder_path = $parent_folder->folder_path;
            } else {
                $folder_path = '/media/'. $root_folder . '/';
            }

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $mime_type = $file->getClientMimeType();
                $file_size = $file->getSize();
                $file_size = number_format($file_size / 1048576,2)."MB";
                if ($request->get('name')) {
                    $file_name = $request->get('name');;
                    $file_type = $file->extension();
                    $file_name = $file_name . '.' . $file_type;
                }

                if(File::where('name', $file_name)->exists()){
                    session()->flash('alert-class', 'danger');
                    session()->flash('message', 'File name already exists in the database, please change the file name.');
                }
                else{
                    $create_path = public_path($folder_path);
                    $file->move($create_path, $file_name);
                    $file_path= $folder_path . $file_name;
                    // $file_path = '/media/' . $user . '/' . $file_name;

                    $file = File::create([
                        'name' => $file_name,
                        'mime_type' => $mime_type,
                        'file_path' =>  $file_path,
                        'file_size' => $file_size,
                    ]);

                    $file->folder_id= $folder_id;
                    $file->save();

                    if ($request->tags) {
                        $tags = $this->decodeTag($request->tags);
                        $file->attachTags($tags);
                    }
                }

                
            }
            if ($folder_id) {
                $url = route('folder.show', $folder_id);
            } else {
                $url = route('home');
            }
            return response()->json(['success' => 'upload success', 'url' => $url]);
        }
        return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
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

        $tags = [];
        if ($request->tags) {
            $tags = $this->decodeTag($request->tags);
            session()->flash('alert-class', 'primary');
            session()->flash('message', 'Tags updated');
        } else {
            if (!auth()->user()->hasRole('administrator')){
                session()->flash('alert-class', 'danger');
                session()->flash('message', 'You do not have permission to remove tags');
                return redirect()->back();
            }
        }

        $file_name = $request->get('name');
        if(auth()->user()->hasRole('youtube')){
            $root_folder = 'youtube';
        }
        elseif(auth()->user()->hasRole('accounting')){
            $root_folder = 'accounting';
        }

        $old_path = $file->file_path;
        if ($file->folder_id) {
            $parent_folder = Folder::firstWhere('id', $file->folder_id);
            $new_path = $parent_folder->folder_path . '/' . $file_name;
        } else {
            $new_path = '/media/'. $root_folder . '/' . $file_name;
        }

        FileStorage::move(public_path($old_path), public_path($new_path));
        $file->update([
            'name' => $file_name, 
            'file_path' => $new_path
        ]);

        $file->syncTags($tags);

        if ($file->folder) {
            return redirect()->route('folder.show', $file->folder_id);
        }
        return redirect()->route('home');
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
        return redirect()->route('home');
    }

    public function decodeTag($tags){
        $decoded_tags = [];
        $init_tags = json_decode($tags, true);
        for ($i=0; $i<count($init_tags); $i++) {
            $decoded_tags[$i] = $init_tags[$i]['value'];
        }
        return $decoded_tags; 
    }

    public function filter(Request $request){
        $files = new File;
        $folders = [];
        $search = $request->query('search');
        $sort_column = $request->query('sort_column');
        $sort_type = $request->query('sort_type');
        
        if ($search){
            $files = $files->withAnyTags([$search]);
        }        

        switch ($sort_column){
            case 'name':
                $files = $files->orderBy('name', $sort_type);
                break;
            case 'size':
                $files = $files->orderBy('file_size', $sort_type);
                break;
            case 'date':
                $files = $files->orderBy('created_at', $sort_type);
                break;
                
        }

        if ($request->ajax()){
            $files = $files->paginate(10)->withQueryString();
            return response()->json([
                'table' => view('file.table', compact('files', 'folders'))->render(),
            ]);
        }
    }

    public function export(){
        return Excel::download(new MainExport, 'Drive-Livei'. date('-Y-m-d-h-i-s') .'.xlsx');
    }

    public function importView(){
        return view('file.import');
    }

    public function import(Request $request){
        $file = $request->file('file')->store('import');
        Excel::import((new MainImport), $file);
        return redirect()->route('home');
    }

}
