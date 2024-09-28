<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Permission::create(['name' => 'create-users']);
      Permission::create(['name' => 'edit-users']);
      Permission::create(['name' => 'delete-users']);


      $adminRole = Role::create(['name' => 'Admin']);
      $editorRole = Role::create(['name' => 'Editor']);

      $adminRole->givePermissionTo([
        'create-users',
        'edit-users',
        'delete-users'
      ]);

      $editorRole->givePermissionTo([
        'edit-users',
      ]);
    }
}
