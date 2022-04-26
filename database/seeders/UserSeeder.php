<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::factory()->create([
            'name' => 'Providence Ifeosame',
            'username' => 'provydon',
            'email' => 'providence@reftek.co',
            'password' => Hash::make('favour007'),
        ]);
        
        User::factory(10)->create(); 
    }
}
