<?php

namespace App\Imports;

use App\Models\Folder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\File as FileStorage;

class FoldersImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if(Folder::where('id', $row['id'])->exists()){
                // update
                $folder = Folder::find($row['id']);
                if($folder->name != $row['name']){
                    session()->flash('alert-class', 'danger');
                    session()->flash('message', 'Warning! Some folders were modified via spreadsheet');
                }
                else{
                    if(auth()->user()->hasRole('youtube')){
                    $root_folder = 'youtube';
                    }
                    elseif(auth()->user()->hasRole('accounting'))
                    {
                        $root_folder = 'accounting';
                    }

                    $name = $row['name'];
                    $parent_id = $row['parent_id'];
                    $old_path = $folder->folder_path;

                    if ($folder->parent_id) 
                        {
                            $parent_folder = Folder::firstWhere('id', $folder->parent_id);
                            $new_path = $parent_folder->folder_path . $name . '/';
                        } 
                    else 
                        {
                            $new_path = '/media/'. $root_folder . '/' . $name . '/';
                        }


                    FileStorage::move(public_path($old_path), public_path($new_path));
                    $folder->update([
                        'name' => $name,
                        'folder_path' => $new_path,
                    ]);
                }
            }
            else
                {
                    // create
                    $folder_path = $row['folder_path'];
                    $folder = Folder::create([
                        'name' => $row['name'],
                        'folder_path' => $folder_path,
                        'parent_id' => $row['parent_id'],
                    ]);
                    $create_path = public_path($folder_path);
                    if(!FileStorage::isDirectory($create_path)){
                        FileStorage::makeDirectory($create_path, 0777, true, true);
                    }
                }
        }
    }
}
