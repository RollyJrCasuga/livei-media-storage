<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'administrator']);
        $role2 = Role::create(['name' => 'staff']);
        $role3 = Role::create(['name' => 'youtube']);

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@livei.com',
            'password' => bcrypt('liveiadmin'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'first_name' => 'Staff',
            'last_name' => 'User',
            'email' => 'staff@livei.com',
            'password' => bcrypt('liveistaff'),
            'email_verified_at' => now(),
    ]);
        $user->assignRole($role2);
    }
}
