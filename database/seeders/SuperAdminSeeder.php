<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role=Role::create([
            'name'=>'Super Admin'
        ]);

        $user=User::create([
            'name'=>'Super Admin',
            'username'=>'superadmin',
            'password'=>Hash::make('123456'),
        ]);

        $user->assignRole($role);
    }
}
