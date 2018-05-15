<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Ciudadano extends Authenticatable
{
	protected $table="ciudadano";
    
    protected $primaryKey = 'idciudadano';

    public $timestamps = false;

    protected $hidden = ['password'];

    

    public function denuncia(){
    	return $this->hasMany('android_models\Denuncia','ciudadano_idciudadano','idciudadano');
    }
}
