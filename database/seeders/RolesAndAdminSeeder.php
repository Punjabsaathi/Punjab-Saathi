<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'staff']);

        $user = User::firstOrCreate(
            ['email' => 'admin@punjabsewakendra.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('Admin@1234'),
            ]
        );
        $user->assignRole('admin');
    }
}