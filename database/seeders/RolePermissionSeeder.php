<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Create Roles and Assign Permissions
        $ownerRol = Role::firstOrCreate(['name' => 'owner']);
        $dataEntryRol = Role::firstOrCreate(['name' => 'dataEntry']);

        $owner = User::updateOrCreate([
            'name' => 'owner',
            'email' => 'owner@foodfelmood.com',
            'email_verified_at' => now(),
            'password' => Hash::make('owner')
        ]);

        $dataEntry = User::updateOrCreate([
            'name' => 'data entry',
            'email' => 'data_entry@foodfelmood.com',
            'email_verified_at' => now(),
            'password' => Hash::make('adminadmin')
        ]);
           // Assign Role
           $owner->assignRole('owner');
           $dataEntry->assignRole('dataEntry');

    }
}
