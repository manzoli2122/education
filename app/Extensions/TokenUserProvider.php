<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\UserProvider;
use App\User;
//use App\Services\ValidarUsuarioRedeException;
//use App\Services\UsuarioSemCadastroSAUException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Provider para autenticação de usuário
 *
 * @author vinicius.jacobsem
 */
class TokenUserProvider implements UserProvider{
    
    

    public function retrieveByCredentials(array $credentials) {
        if (empty($credentials)) {
            return;
        }
        
        // return $credentials['token'];






        try {
            $usuario = User::where('id',1 )->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            $usuario = new User;
            //$usuario->login = $credentials['login'];
        }
        
        //$usuario->password = $credentials['password'];
        return $usuario;
    }









    // public function retrieveByCredentials1(array $credentials) {
    //     if (empty($credentials)) {
    //         return;
    //     } 
    //     try {
    //         $usuario = User::where('login', $credentials['login'])->firstOrFail();
    //     } catch (ModelNotFoundException $ex) {
    //         $usuario = new User;
    //         $usuario->login = $credentials['login'];
    //     }
        
    //     $usuario->password = $credentials['password'];
    //     return $usuario;
    // }




    public function validateCredentials(  $usuario, array $credentials): bool {
        // try{
        //     $usuario->validarUsuarioRede();
        // } catch (ValidarUsuarioRedeException $ex){
        //     return false;
        // } catch (\Exception $ex){
        //     session(['msg-erro' => __('msg.erro_autenticacao_pmes')]);
        //     return false;
        // }
        
        return true;
    }



    
    // public function validateCredentials1(\Illuminate\Contracts\Auth\Authenticatable $usuario, array $credentials): bool {
    //     try{
    //         $usuario->validarUsuarioRede();
    //     } catch (ValidarUsuarioRedeException $ex){
    //         return false;
    //     } catch (\Exception $ex){
    //         session(['msg-erro' => __('msg.erro_autenticacao_pmes')]);
    //         return false;
    //     }
        
    //     return true;
    // }





    public function retrieveById($identifier) {
        return User::where('id', $identifier)->first();
    }




    public function retrieveByToken($identifier, $token) {
        return null;
    }




    public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $usuario, $token){
        
    }




}
