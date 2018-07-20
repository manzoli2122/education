<?php

namespace App\Models\Security;


use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use DB;

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
        return $this->with('pertfil' , 'autor')->select(['id','acao', 'ip_v4', 'host' , 'user_id', 'autor_id', 'perfil_id' , 'created_at' ]);        
    }
    

 
 




  


    public function save(array $options = [])
    {    
        if (!parent::save($options)) {
            return false;
        } 
        return true;
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



    public function pertfil()
    {
        return $this->belongsTo('App\Models\Perfil', 'perfil_id'); 
    }

 
    
   

}
