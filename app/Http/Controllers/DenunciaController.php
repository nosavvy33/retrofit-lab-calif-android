<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use App\Models\Ciudadano;
class DenunciaController extends Controller
{
    public function index($idciudadano){
   
    	$denuncias = Denuncia::where('ciudadano_idciudadano',$idciudadano)->get()->toArray();
    	echo json_encode($denuncias);
    	
    }

    public function store(Request $request){
    	date_default_timezone_set("America/Lima");
		$a = date("Y-m-d H:i:s");
    	$denuncia = new Denuncia;
    	$denuncia->titulo = $request->titulo;
    	$denuncia->descripcion = $request->descripcion;
    	$denuncia->ubicacion = $request->ubicacion;
    	$denuncia->fecha_hora = $a;
    	$denuncia->ciudadano_idciudadano = $request->idciudadano;
    	$denuncia->save();
    	return "Denuncia reportada exitosamente";
    }

    public function destroy(Request $request){
    	$denuncia = Denuncia::find($request->iddenuncia);
    	$denuncia->destroy($denuncia->iddenuncia) or die("Error al eliminar denuncia");
    	return "Denuncia eliminada exitosamente";
    }
}
