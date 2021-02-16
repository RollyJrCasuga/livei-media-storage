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
        ]);

        Folder::create([
            'id' => 2,
            'parent_id' => null,
            'name' => 'Palawan',
        ]);
    }
}
