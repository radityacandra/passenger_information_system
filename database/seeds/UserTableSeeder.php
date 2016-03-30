<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->delete();

    DB::table('users')->insert([
        'name'  => 'Raditya Chandra Buana',
        'email' => 'radityacandra@gmail.com',
        'password'  => 'bolehmasuk',
        'created_at'=> \Carbon\Carbon::now(),
        'updated_at'=> \Carbon\Carbon::now(),
        'profile_img' => 'https://avatars0.githubusercontent.com/u/8519058?v=3&s=460',
        'role'  => 'admin',
    ]);

    DB::table('users')->insert([
      'name'  => 'Halte Maguwo',
      'email' => 'maguwo@halte.id',
      'password'  => 'bolehmasuk',
      'created_at'=> \Carbon\Carbon::now(),
      'updated_at'=> \Carbon\Carbon::now(),
      'role'  => 'halte',
      'halte_id'  => 5
    ]);
  }
}
