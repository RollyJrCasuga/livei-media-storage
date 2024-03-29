<?php

namespace App\Http\Controllers;

use Exception;
use FFMpeg\FFMpeg;
use App\Models\File;
use Spatie\Tags\Tag;
use App\Models\Folder;
use App\Exports\MainExport;
use App\Imports\MainImport;
use App\Exports\FilesExport;
use App\Imports\FilesImport;
use Illuminate\Http\Request;
use FFMpeg\Coordinate\TimeCode;
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
        $validator = validator($request->all(), [
            'files'     => 'required|max:15000000',
            'files.*'   => 'mimes:mp4,jpeg,jpg,png',
            'tags'      => 'required',
        ], [
            'tags.required' => 'Please add tags',
            'files.*.mimes'   => 'You can only upload with the following file types: mp4, jpeg, jpg, png.',
        ]);

        if ($validator->fails()) {
            session()->flash('alert-class', 'danger');
            session()->flash('message', $validator->errors()->all());
            return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
        }

        if ($files = $request->file('files'))
        {
            $root_folder = 'youtube';
            $folder_id = $request->get('folder_id');

            if ($folder_id) {
                $parent_folder = Folder::firstWhere('id', $folder_id);
                $folder_path = $parent_folder->folder_path;
            } else {
                $folder_path = "/media/{$root_folder}/";
            }

            $_name = $request->get('name');

            foreach ($files as $file) {
                if ($_name) {
                    $name_only = $_name;
                    $file_name = $_name . '.' . $file->extension();
                } else {
                    $file_name = $file->getClientOriginalName();
                    $name_only = pathinfo($file_name, PATHINFO_FILENAME);
                }

                if (File::firstWhere('name', $name_only)) {
                    session()->flash('alert-class', 'danger');
                    session()->flash('message', 'File name already exists in the database, please change the file name.');
                    return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
                }

                $mime_type = $file->getClientMimeType();
                $file_size = $file->getSize();
                $file_size = number_format($file_size / 1048576,2)."MB";

                $create_path = public_path($folder_path);
                $save_video = $file->move($create_path, $file_name);
                $file_path = $folder_path . $file_name;

                if ($save_video) {

                    $file = File::create([
                        'name'      => $name_only,
                        'file_name' => $file_name,
                        'mime_type' => $mime_type,
                        'file_path' => $file_path,
                        'file_size' => $file_size,
                    ]);

                    if ($folder_id) {
                        $file->folder_id = $folder_id;
                        $file->save();
                    }

                    if ($request->tags) {
                        $tags = $this->decodeTag($request->tags);
                        $file->attachTags($tags);
                    }

                    // if (strpos($mime_type, 'video') !== false) {
                    //     $thumbnail = 'video-'.$file->id.'.jpg';
                    //     $new_folder = "{$folder_path}thumbnail/";
                    //     $new_folder = "/media/{$root_folder}/thumbnail/";
                    //     $create_path = public_path($new_folder);

                    //     if(!FileStorage::isDirectory($create_path)){
                    //         FileStorage::makeDirectory($create_path, 0775, true, true);
                    //     }

                    //     $thumbnail_path = public_path($new_folder).$thumbnail;
                    //     $create_path = public_path($folder_path);

                    //     $ffmpeg = FFMpeg::create([
                    //         'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
                    //         'ffprobe.binaries' => '/usr/local/bin/ffprobe',
                    //         'timeout'          => 3600,
                    //         'ffmpeg.threads'   => 12,
                    //     ], $logger);

                    //     $video = $ffmpeg->open(public_path($file_path));
                    //     $generate_thumbnail = $video->frame(TimeCode::fromSeconds(2))
                    //                                 ->save($thumbnail_path);

                    //     if (!$generate_thumbnail){
                    //         session()->flash('alert-class', 'danger');
                    //         session()->flash('message', 'Can not generate thumbnail');
                    //     }

                    //     $file->thumbnail = $thumbnail;
                    //     $file->thumbnail_path = "{$new_folder}{$thumbnail}";
                    //     $file->save();
                    // }
                }

                $url = ($folder_id) ? route('folder.show', $folder_id) : route('home');
                session()->flash('alert-class', 'success');
                session()->flash('message', 'Upload success');
                return response()->json(['success' => 'upload success', 'url' => $url]);
            }
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
        $validator = validator($request->all(), [
            'name' => 'required|max:255',
            'tags' => 'required'
        ], [
            'tags.required' => 'Please add tags',
        ]);

        if ($validator->fails()) {
            session()->flash('alert-class', 'danger');
            session()->flash('message', $validator->errors()->all());
            return response()->json(['error' => 'upload error', 'url' => url()->previous()]);
        }

        $name = $request->get('name');
        $file_name = $name . '.' . pathinfo($file->file_name, PATHINFO_EXTENSION);

        // if(auth()->user()->hasRole('youtube')){
        //     $root_folder = 'youtube';
        // }
        // elseif(auth()->user()->hasRole('accounting')){
        //     $root_folder = 'accounting';
        // }

        $root_folder = 'youtube';

        $old_path = $file->file_path;
        if ($file->folder_id) {
            $parent_folder = Folder::firstWhere('id', $file->folder_id);
            $new_path = $parent_folder->folder_path . '/' . $file_name;
        } else {
            $new_path = "/media/{$root_folder}/{$file_name}";
        }

        FileStorage::move(public_path($old_path), public_path($new_path));

        $file->update([
            'name'      => $name,
            'file_name' => $file_name,
            'file_path' => $new_path
        ]);

        $tags = $this->decodeTag($request->tags);
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

        $delete = $file->delete();
        if(!$delete){
            session()->flash('alert-class', 'danger');
            session()->flash('message', 'Delete error!');
            return redirect()->back();
        }
        session()->flash('alert-class', 'success');
        session()->flash('message', 'File deleted!');
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
        $import = Excel::import((new MainImport), $file);
        if(!$import){
            session()->flash('alert-class', 'danger');
            session()->flash('message', 'Import error!');
            return redirect()->back();
        }
        session()->flash('alert-class', 'success');
        session()->flash('message', 'Import success!');
        return redirect()->route('home');
    }

}
