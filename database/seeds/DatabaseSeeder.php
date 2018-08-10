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
            'name' => 'Administrador.dtic',
            'email' => 'manzoli2122@gmail.com',
            'rg' => 1000,
            'nf' => 1000000,                
            'quadro_dsc' =>'Admin',
            'post_grad_dsc' => "CEL",
            'status' => 'A', 
            'password' => bcrypt('123456'),
            // 'ome_qdi_lft' => 2000 ,
            // 'ome_qdi_rgt' => 3000,
            // 'ome_qdi_id' => 2500,
        ]);




        DB::table('perfils_users')->insert([
            'perfil_id' => 1,
            'user_id' => '00000000001' , 
        ]);
        

         
        DB::table('perfils')->insert([
            'nome' => 'Professor',
            'descricao' =>  'Professor', 
        ]);
          
        DB::table('perfils')->insert([
            'nome' => 'Gerente',
            'descricao' =>  'Gerente', 
        ]);


        DB::table('perfils')->insert([
            'nome' => 'Diretor',
            'descricao' =>  'Diretor', 
        ]);


        DB::table('permissoes')->insert([
            'nome' => 'perfis',
            'descricao' =>  'perfis', 
        ]);



        DB::table('mailable')->insert([ 
            'nome' =>  'Login', 
            'descricao' =>  'Envio de email a cada acesso', 
        ]);

        DB::table('mailable')->insert([ 
            'nome' =>  'Perfil', 
            'descricao' =>  'Envio de email ao ser adicionado ou retirado um perfil do Usuário', 
        ]);


        DB::table('users_mailable')->insert([
            'mailable_id' => 1,
            'user_id' => '00000000001' , 
        ]);

        DB::table('users_mailable')->insert([
            'mailable_id' => 2,
            'user_id' => '00000000001' , 
        ]);

    }
}
