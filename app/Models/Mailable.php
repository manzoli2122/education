<?php

namespace App\Models;

use Cache; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Cache\TaggableStore; 


class Mailable extends Model
{    
 

    protected $table = 'mailable'; 
  
    
    protected $fillable = [
              'descricao', 'nome'
    ];


    protected $hidden = [
        'created_at' ,     'updated_at' ,  
    ];
        

    // public function log( )
    // {
    //     return [
    //         'perfil' => [ 
    //             'id' => $this->id,
    //              'nome' => $this->nome , 
    //             // 'descricao' => $this->descricao , 
    //         ]       
    //     ];
    // }


    // public function rules($id = '')
    // {
    //         return [
    //             'nome' => 'required|min:3|max:100',
    //             'descricao' => "required|min:1|max:150",     
    //         ];
    // }
 
 

    
    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'users_mailable', 'mailable_id', 'user_id' );
    }


    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }
    
 
     
    // public static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function ($perfil) {
    //         if (!method_exists( 'App\Models\Security\Perfil' , 'bootSoftDeletes')) {
    //             $perfil->usuarios()->sync([]);
    //             $perfil->permissoes()->sync([]);
    //         }
    //         return true;
    //     });
    // }
    
     
  

}
