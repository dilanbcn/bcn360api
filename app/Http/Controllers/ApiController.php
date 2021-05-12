<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
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

                $rutaOrigen = $directorioRaiz . $archivo->ruta . "\\" . $archivo->nombre_archivo;
                $rutaDestino = $rutaDestino . "\\" . $archivo->nombre_archivo;

                File::move($rutaOrigen, $rutaDestino);
                $archivo->ruta = $destino;
                $archivo->save();
            });
        }
    }

    public function usuariosArchivo($archivoId)
    {
        $pivotUsuarios = DB::table('archivo_usuario')
            ->select('usuario_id')
            ->where('archivo_id', $archivoId)
            ->get();

        $datosUsuarios = null;

        if (count($pivotUsuarios) > 0) {

            foreach ($pivotUsuarios as $usuario) {
                $arrUsu[] = $usuario->usuario_id;
            }

            $datosUsuarios = DB::table('usuarios')
                ->select('id', 'nombre', 'apellido')
                ->whereIn('id', $arrUsu)
                ->get();
        }

        return $datosUsuarios;
    }

    public function carpetaUsuario($usuarioId)
    {
        $arrArchivos = DB::table('archivo_usuario')
            ->select('archivo_id')
            ->where('usuario_id', $usuarioId)
            ->get();

        $archivos = null;

        if (count($arrArchivos) > 0) {

            foreach ($arrArchivos as $archivo) {
                $arrArch[] = $archivo->archivo_id;
            }

            $archivos = Carpeta::with('archivo')->whereHas('archivo', function($sql) use ($arrArch){
                return $sql->whereIn('id', $arrArch);
            })->get();

            $collectUser['archivos'] = $archivos;
        }

        return $archivos;
    }
}
