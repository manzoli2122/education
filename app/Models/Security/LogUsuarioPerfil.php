<?php

namespace App\Models\Security; 
 
use Illuminate\Database\Eloquent\Model; 

class LogUsuarioPerfil extends Model
{    
 

    protected $table = 'usuario_perfil_log'; 

     
    
    protected $fillable = [
        'user_id', 'autor_id', 'perfil_id', 'acao', 'ip_v4' , 'host'
    ];



    protected $hidden = [
        'updated_at' ,  
    ];
         

    public function getDatatable($id)
    {
        return $this->with('perfil' , 'usuario', 'autor')->select('usuario_perfil_log.*')->where('usuario_perfil_log.user_id' , $id); 
    }
     

    public function delete(array $options = [])
    {    
        return false; 
    }
  

    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id'); 
    }
 
    
    public function autor()
    {
        return $this->belongsTo('App\User', 'autor_id'); 
    }
 

    public function perfil()
    {
        return $this->belongsTo('App\Models\Security\Perfil', 'perfil_id'); 
    }
 

}
