<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Folder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Folder::create([
            'id' => 1,
            'parent_id' => null,
            'name' => 'Boracay',
            'folder_path' => '/media/Admin/Boracay/'
        ]);

        Folder::create([
            'id' => 2,
            'parent_id' => 1,
            'name' => 'Beach',
            'folder_path' => '/media/Admin/Boracay/Beach/'
        ]);
        Folder::create([
            'id' => 3,
            'parent_id' => 2,
            'name' => 'White Sand',
            'folder_path' => '/media/Admin/Boracay/Beach/White Sand/'
        ]);
        Folder::create([
            'id' => 4,
            'parent_id' => null,
            'name' => 'Coconut',
            'folder_path' => '/media/Admin/Coconut/'
        ]);
    }
}
