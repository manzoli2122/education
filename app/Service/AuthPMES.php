<?php

namespace App\Services;

class ValidarUsuarioRedeException extends \Exception{}
class UsuarioSemCadastroSAUException extends \Exception{}

/**
 * Interage com a WebAPI de autenticação da PMES. 
 * Essa WebAPI consome dados do SAU e valida usuário na rede PMES 
 *
 * @author vinicius.jacobsem
 */
class AuthPMES {
    const URL_BASE = "http://api.pm.es.gov.br/auth";

    /**
     * Valida o usuário e a senha na rede PMES (usuário AD)
     * 
     * @param string $login
     * @param string $senha
     * @return string Nome do Usuário
     * @throws ValidarUsuarioRedeException, SemComunicacaoException
     */
    public static function validarUsuarioRede($login, $senha){
        $url = self::URL_BASE . "/AD/ValidarUsuario?usuario=$login&senha=" . urlencode($senha);
        
        $retorno = file_get_contents($url);
        if($retorno){
            $retorno = json_decode($retorno);
            
            if($retorno->erro){
                throw new ValidarUsuarioRedeException($retorno->mensagem);
            }
            
            return $retorno->nomeUsuario;
        }
        
        throw new SemComunicacaoException();
    }
    
    /**
     * Busca o usuário na base do SAU
     * 
     * @param string $login Login da Rede PMES
     * @return object JSON decodificado com dados do usuário retornado pelo SAU
     */
    public static function pesquisaUsuarioPeloLogin($login){
        $url = self::URL_BASE . "/UsuarioAdm/PesquisaUsuarioPeloLogin?login=$login";
        
        $retorno = file_get_contents($url);
        if($retorno){
            
            if(strtolower($retorno) == "null"){
                throw new UsuarioSemCadastroSAUException();
            }
            
            return json_decode($retorno);
        }
        
        throw new SemComunicacaoException();
    }
}
