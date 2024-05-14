<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'cpf' => '12345678900',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => Hash::make('password'),
                'phone' => '5234567890',
                'cpf' => '52345678900',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        DB::table('users')->insert([
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'phone' => '4234567890',
                'cpf' => '42345678900',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
