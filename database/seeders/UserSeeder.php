<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $users = User::factory(200)->create();

      $admin = User::create([
        'username' => 'Shahzod',
        'first_name' => 'Shakhzod',
        'email' => 'shahzodrashidov0307@gmail.com',
        'password' =>Hash::make('admin123'),
      ]);
      $manager = User::create([
        'username' => 'Karim_0205',
        'first_name' => 'Karimbek',
        'email' => 'karimnajimov0205@gmail.com',
        'password' =>Hash::make('admin123'),
      ]);
      $admin->assignRole('Administrator');
      $users->each(function ($user) {
        $user->assignRole('User');
      });
      $manager->assignRole('Manager');
    }
}
