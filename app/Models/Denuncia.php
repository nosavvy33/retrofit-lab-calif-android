<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table="denuncia";
    
    protected $primaryKey = 'iddenuncia';

    public $timestamps = false;


    public function ciudadano(){
    	return $this->belongsTo('App\Models\Ciudadano','idciudadano','ciudadano_idciudadano');
    }
}
