<?php

namespace App\Models\Security;

  
use Illuminate\Database\Eloquent\Model;


class Permissao extends Model  
{
     
      

    protected $table = 'permissoes';
     


    protected $fillable = [
            'nome', 'descricao', 
    ];




    protected $hidden = [
        'updated_at' ,  'created_at' , 'pivot'
    ];


    


    /**
     * retorna um array dos dados para gravar em log
     *
     * @return $array
     */
    public function log( )
    {
        return [
            'permissao' => [ 
                'id' => $this->id,
                 'nome' => $this->nome , 
                 'descricao' => $this->descricao , 
            ]       
        ];
    }
        






    /**
     * Retorna as regras de validações para cadastro e atualização
     *
     * @return $rules
     */
    public function rules($id = '')
    {
            return [
                'nome' => 'required|min:3|max:100',
                'descricao' => "required|min:1|max:100",     
            ];
    }







    /**
     * Funcao para auxiliar o datatable de listar os perfis.
     *
     * @return $permissoes
     */
    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }

 
    




    /**
     * Retorna os perfis que possui a permissao.
     *
     * @return $usuarios
     */
    public function perfis()
    {
        return $this->belongsToMany('App\Models\Security\Perfil' , 'permissao_perfils', 'permissao_id', 'perfil_id');
    }

   
 




    /**
     * Retorna as permissoes que um perfil não possui
     *
     * @return $permissoes
     */
    public  function permissaoParaAdicionarAoPerfil($perfil_id)
    {
        return $this->whereNotIn('id', function($query) use ($perfil_id){
            $query->select("permissao_perfils.permissao_id");
            $query->from("permissao_perfils");
            $query->whereRaw("permissao_perfils.perfil_id = {$perfil_id} ");
        } )
        ->orderBy('nome')->get();  
    }
 
 
 

}
