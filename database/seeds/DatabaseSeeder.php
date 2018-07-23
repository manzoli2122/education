<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);


        DB::table('perfils')->insert([
            'nome' => 'Admin',
            'descricao' =>  'Admin', 
        ]);



        DB::table('users')->insert([
            'name' => 'bruno',
            'email' =>  'manzoli2122@gmail.com',
            'password' => bcrypt('123'),
        ]);

        
        DB::table('perfils_users')->insert([
            'perfil_id' => 1,
            'user_id' => 1, 
        ]);
        

        DB::table('users')->insert([
            'name' => 'teste',
            'email' =>  'teste@gmail.com',
            'password' => bcrypt('teste'),
        ]);



    }
}
