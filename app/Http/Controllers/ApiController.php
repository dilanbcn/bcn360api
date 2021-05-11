<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str as Str;

class ApiController extends Controller
{
    use ApiResponser;


    public function obtenerPath($request, $carpeta = null)
    {
        if ($request->has('padre')) {
            if ($request->get('padre')) {
                $path = Carpeta::find($request->get('padre'))->path . '\\' . Str::slug($request->get('nombre'));
            } else {
                $path = Str::slug($request->get('nombre'));
            }
        } else {
            if ($carpeta) {
                $path = Carpeta::find($carpeta->padre_id)->path . '\\' . Str::slug($request->get('nombre'));
            } else {

                $path = Str::slug($request->get('nombre'));
            }
        }

        return $path;
    }

    public function moverArchivos($carpetaId, $destino)
    {

        $archivos = Archivo::where('carpeta_id', $carpetaId)->get();

        if ($archivos) {

            $directorioRaiz = public_path(config('app.archivos_url'));
            $rutaDestino = $directorioRaiz . $destino;

            
            if (!file_exists($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0755, true);
            }

            $archivos->map(function ($archivo) use ($rutaDestino, $directorioRaiz, $destino) {

                $rutaOrigen = $directorioRaiz.$archivo->ruta."\\".$archivo->nombre_archivo;
                $rutaDestino = $rutaDestino."\\".$archivo->nombre_archivo;

                File::move($rutaOrigen, $rutaDestino);
                $archivo->ruta = $destino;
                $archivo->save();
            });
        }

    }
}
