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


            'id' => '00000000001',
            'name' => 'Administrador',
            'rg' => 1000,
            'nf' => 1000000,                
            'quadro_dsc' =>'Admin',
            'post_grad_dsc' => "CEL",
            'status' => 'A', 
            'password' => bcrypt('123456'),
           

        ]);

        
        DB::table('perfils_users')->insert([
            'perfil_id' => 1,
            'user_id' => '00000000001' , 
        ]);
        

        // DB::table('users')->insert([
        //     'name' => 'teste',
        //     'email' =>  'teste@gmail.com',
        //     'password' => bcrypt('teste'),
        // ]);



    }
}
