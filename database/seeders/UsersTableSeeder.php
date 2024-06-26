<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // Create the user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@books.local'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password')
            ]
        );
        $admin->assignRole($adminRole);

        $admin->createToken('default');

        // Create regular user
        $user = User::firstOrCreate(
            ['email' => 'user@books.local'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password')
            ]
        );
        $user->assignRole($userRole);

        $user->createToken('default');
    }
}
