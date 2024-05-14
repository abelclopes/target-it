<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Troque 'id' pelos IDs reais dos usuários e das funções na sua tabela
        $data = [
            ['user_id' => 1, 'role_id' => 1,'created_at' => now(),
            'updated_at' => now()],
            ['user_id' => 2, 'role_id' => 2,'created_at' => now(),
            'updated_at' => now()],
            
        ];

        // Inserir dados na tabela role_user
        DB::table('role_user')->insert($data);
    }
}
