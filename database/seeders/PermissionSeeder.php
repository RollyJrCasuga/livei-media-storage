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
            'first_name' => 'SuperAdmin',
            'last_name' => 'User',
            'email' => 'admin@livei.com',
            'password' => bcrypt('liveiadmin2021'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role1);
        $user = User::create([
            'first_name' => 'Jeff',
            'last_name' => 'Rhoades',
            'email' => 'jeff@livei.com',
            'password' => bcrypt('driveadmin2021'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role1);
        $user = User::create([
            'first_name' => 'Milo',
            'last_name' => 'Mamangco',
            'email' => 'milo@livei.com',
            'password' => bcrypt('driveadmin2021'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role1);
    }
}