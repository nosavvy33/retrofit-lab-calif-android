<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use App\Models\Ciudadano;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class DenunciaController extends Controller
{
	//https://stackoverflow.com/questions/39703655/how-to-upload-image-on-server-using-volley?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
	//https://stackoverflow.com/questions/34562950/post-multipart-form-data-using-retrofit-2-0-including-image?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
	//https://stackoverflow.com/questions/36730086/retrofit-2-url-query-parameter?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    public function index($idciudadano){
   
    	$denuncias = Denuncia::where('ciudadano_idciudadano',$idciudadano)->get()->toArray();
    	return json_encode($denuncias);
    	
    }

    public function store(Request $request){
        try{
            if(!$request->has('ubicacion') || !$request->has('idciudadano') || !$request->has('descripcion') || !$request->has('titulo')){
                throw new \Exception('Se esperaba campos obligatorios');
            }
            $ciudadano = Ciudadano::find($request->idciudadano);
        date_default_timezone_set("America/Lima");
        $a = date("Y-m-d H:i:s");
        $denuncia = new Denuncia;
        $denuncia->titulo = $request->titulo;
        $denuncia->descripcion = $request->descripcion;
        $denuncia->ubicacion = $request->ubicacion;
        $denuncia->fecha_hora = $a;
        $denuncia->ciudadano_idciudadano = $request->idciudadano;
        if($request->hasFile('foto') && $request->file('foto')->isValid()){
            $foto = $request->file('foto');
            $filename = $ciudadano->username.$request->file('foto')->getClientOriginalName();
            Storage::disk('images')->put($filename, File::get($foto));
            $denuncia->foto = $filename;
        }
            $denuncia->save();

            return response()->json(['type'=>'success','message'=>'Denuncia registrada'],200 );
        }catch(\Exception $e){
            return response()->json(['type'=>'error','message'=>$e->getMessage()],500);
        }
	
    }

    public function destroy(Request $request){
    	$denuncia = Denuncia::find($request->iddenuncia);
    	$denuncia->destroy($denuncia->iddenuncia) or die("Error al eliminar denuncia");
    	return "Denuncia eliminada exitosamente";
    }
}
