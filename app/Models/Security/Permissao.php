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
        'deleted_at' ,   'updated_at' ,  'created_at' , 'pivot'
    ];

    
        
    public function rules($id = '')
    {
            return [
                'nome' => 'required|min:3|max:100',
                'descricao' => "required|min:0|max:100",     
            ];
    }


    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }

 
    
     public function perfis()
    {
        return $this->belongsToMany('App\Models\Security\Perfil' , 'permissao_perfils', 'permissao_id', 'perfil_id');
    }

   
 



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
