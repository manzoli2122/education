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
       




    
    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'users_mailable', 'mailable_id', 'user_id' );
    }







    /**
     * Funcao para auxiliar o datatable de listar os perfis.
     *
     * @return $mailable
     */
    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }
    
 
     
  

}
