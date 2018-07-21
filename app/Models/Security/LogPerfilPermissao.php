<?php

namespace App\Models\Security;
 
use Illuminate\Database\Eloquent\Model; 

class LogPerfilPermissao extends Model
{    

     

    protected $table = 'perfil_permissao_log'; 

     
    
    protected $fillable = [
        'permissao_id', 'autor_id', 'perfil_id', 'acao', 'ip_v4' , 'host'
    ];



    protected $hidden = [
        'updated_at' ,  
    ];
        
     


    public function getDatatable($id)
    {
        return $this->with('perfil' , 'permissao', 'autor')->select('perfil_permissao_log.*')->where('perfil_permissao_log.perfil_id' , $id); 
    }
    

  



    public function delete(array $options = [])
    {    
        return false; 
    }
 

   



    public function permissao()
    {
        return $this->belongsTo('App\Models\Permissao', 'permissao_id'); 
    }




    
    public function autor()
    {
        return $this->belongsTo('App\User', 'autor_id'); 
    }



    public function perfil()
    {
        return $this->belongsTo('App\Models\Perfil', 'perfil_id'); 
    }

 
    
   

}
