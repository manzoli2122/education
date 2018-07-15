<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;
 



class Disciplina extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'disciplina'; 


    protected $fillable = [
            'nome',   'descricao' 
    ];


    protected $hidden = [
              'deleted_at' ,     'updated_at' ,
    ];





    public function rules($id = ''){
        return [
            'nome' => 'required|min:3|max:191',
            'descricao' => 'required|min:3|max:500',                
        ];
    }



    
    public function getDatatable(){
        return $this->select([ 'id' ,  'nome', 'descricao',   ]);        
    }
    
   

    public function assuntos(){
        // return $this->hasMany('App\Models\Assunto', 'disciplina_id', 'id'); 
    }


    
}
