<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Calls;
use App\Models\Ratings;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
      $this->call([
          RoleAndPermissionSeeder::class,
          UserSeeder::class,
      ]);

//    $users = User::factory()->count(200)->create();
//    foreach ($users as $user){
//      $user-->assignRole('User');
//    }
    Calls::factory()->count(200)->create();
    Ratings::factory()->count(200)->create();
  }
}
