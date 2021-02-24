<?php

namespace App\Imports;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\File as FileStorage;

class FilesImport implements ToCollection, WithHeadingRow
{
    use Importable;
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if(File::where('id', $row['id'])->exists()){
                // update
                // dd('update');
                $file = File::find($row['id']);
                if(auth()->user()->hasRole('youtube')){
                    $root_folder = 'youtube';
                }
                elseif(auth()->user()->hasRole('accounting')){
                    $root_folder = 'accounting';
                }

                $name = $row['name'];
                $folder_id = $row['folder_id'];
                $old_path = $file->file_path;

                if ($file->folder_id) {
                    $parent_folder = Folder::firstWhere('id', $file->folder_id);
                    $new_path = $parent_folder->folder_path . $name;
                } else {
                    $new_path = '/media/'. $root_folder . '/' . $name;
                }

                FileStorage::move(public_path($old_path), public_path($new_path));
                $file->update([
                    'name' => $name,
                    'file_path' => $new_path 
                ]);
                $tags = $row['tags'];
                $tags = explode(', ', $tags);
                $file->syncTags($tags);
            }
            
            else{
                // create
                $file = File::create([
                    'name' => $row['name'],
                    'mime_type' => $row['mime_type'],
                    'file_path' => $row['file_path'],
                    'file_size' => $row['file_size']
                ]);

                if($row['folder_id']){
                    $file->folder_id= $row['folder_id'];
                    $file->save();
                }
                if ($row['tags']) {
                    $tags = $row['tags'];
                    $tags = explode(', ', $tags);
                    $file->attachTags($tags);
                }
            }

            
        }
    }
}
