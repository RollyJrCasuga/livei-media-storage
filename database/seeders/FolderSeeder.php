<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Folder;
use Illuminate\Support\Facades\File as FileStorage;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileStorage::deleteDirectory(public_path('media'));

        // $folder_path = '/media/youtube/Documents/';
        // Folder::create([
        //     'id' => 1,
        //     'parent_id' => null,
        //     'name' => 'Documents',
        //     'folder_path' => $folder_path
        // ]);
        // $create_path = public_path($folder_path);
        // if(!FileStorage::isDirectory($create_path)){
        //     FileStorage::makeDirectory($create_path, 0777, true, true);
        // }

        // $folder_path = '/media/youtube/Documents/Beach/';
        // Folder::create([
        //     'id' => 2,
        //     'parent_id' => 1,
        //     'name' => 'Beach',
        //     'folder_path' => $folder_path
        // ]);
        // $create_path = public_path($folder_path);
        // if(!FileStorage::isDirectory($create_path)){
        //     FileStorage::makeDirectory($create_path, 0777, true, true);
        // }

        // $folder_path = '/media/youtube/Folder/';
        // Folder::create([
        //     'id' => 3,
        //     'parent_id' => null,
        //     'name' => 'Folder',
        //     'folder_path' => $folder_path
        // ]);
        // $create_path = public_path($folder_path);
        // if(!FileStorage::isDirectory($create_path)){
        //     FileStorage::makeDirectory($create_path, 0777, true, true);
        // }
    }
}
