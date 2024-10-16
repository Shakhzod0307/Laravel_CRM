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
      $roles = ['Manager','User','Support','Restricted User'];
//      $superAdmin = Role::create(['name' => 'Super-Admin']);
      $adminRole = Role::create(['name' => 'Administrator']);
      $editorRole = Role::create(['name' => 'Editor']);
      foreach ($roles as  $role){
        Role::create([
          'name' => $role
        ]);
      }

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
