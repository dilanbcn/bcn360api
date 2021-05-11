<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ArchivoRequest;
use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use App\Models\Administracion\TipoArchivo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str as Str;

class ArchivoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archivos = Archivo::all();

        return $this->showAll($archivos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchivoRequest $request)
    {
        $carpeta = Carpeta::find($request->get('carpeta_id'));
        $directorioCompleto = public_path(config('app.archivos_url')) . $carpeta->path;
        $now = Carbon::now();

        if (!file_exists($directorioCompleto)) {
            File::makeDirectory($directorioCompleto, 0755, true);
        }

        if ($request->hasFile('documento')) {
            $extension = strtolower($request->file('documento')->getClientOriginalExtension());
            $name = md5($now->format('YmdHisu'));
            $docName = $name . "." . $extension;
            $request->file('documento')->move($directorioCompleto, $docName);
        }

        $archivo = Archivo::create([
            'carpeta_id' => $request->get('carpeta_id'),
            'nombre' => $request->get('nombre'),
            'privado' => $request->get('privado'),
            'declaracion' => $request->get('declaracion'),
            'creado_por' => $request->get('creado_por'),
            'nombre_descarga' => Str::slug($request->get('nombre')),
            'tipo_archivo_id' => TipoArchivo::where('extension', $extension)->first()->id,
            'ruta' => $carpeta->path,
            'nombre_archivo' => $docName
        ]);

        $archivo->save();

        return $this->showOne($archivo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        return $this->showOne($archivo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(ArchivoRequest $request, Archivo $archivo)
    {

        $directorioRaiz = public_path(config('app.archivos_url'));

        if ($request->hasFile('documento')) {

            $path = $directorioRaiz . $archivo->ruta . '\\' . $archivo->nombre_archivo;
            File::delete($path);

            $carpeta = Carpeta::find($request->get('carpeta_id'));
            $now = Carbon::now();
            $directorioCompleto = $directorioRaiz . $carpeta->path;

            $extension = strtolower($request->file('documento')->getClientOriginalExtension());
            $name = md5($now->format('YmdHisu'));
            $docName = $name . "." . $extension;
            $request->file('documento')->move($directorioCompleto, $docName);

            $archivo->tipo_archivo_id = TipoArchivo::where('extension', $extension)->first()->id;
            $archivo->ruta = $carpeta->path;
            $archivo->nombre_archivo = $docName;
            
        } else {

            if ($archivo->carpeta_id != $request->get('carpeta_id')) {

                $carpeta = Carpeta::find($request->get('carpeta_id'));

                $rutaActual = $directorioRaiz . '\\' . $archivo->ruta . '\\' . $archivo->nombre_archivo;
                $rutaNueva = $directorioRaiz . '\\' . $carpeta->path;

                if (!file_exists($rutaNueva)) {
                    File::makeDirectory($rutaNueva, 0755, true);
                }

                File::move($rutaActual, $rutaNueva . "\\" . $archivo->nombre_archivo);

                $archivo->ruta = $carpeta->path;
            }
        }

        if ($request->get('nombre')) {

            $archivo->nombre = ($request->get('nombre')) ? $request->get('nombre') : $archivo->nombre;
            $archivo->nombre_descarga = Str::slug($request->get('nombre'));

        }

        $archivo->carpeta_id = $request->get('carpeta_id');
        $archivo->creado_por = $request->get('creado_por');
        $archivo->privado = ($request->get('privado')) ? $request->get('privado') : $archivo->privado;
        $archivo->estado = ($request->get('estado')) ? $request->get('estado') : $archivo->estado;
        $archivo->declaracion = ($request->get('declaracion')) ? $request->get('declaracion') : $archivo->declaracion;

        $archivo->save();

        return $this->showOne($archivo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        $directorioRaiz = public_path(config('app.archivos_url'));
        $path = $directorioRaiz . $archivo->ruta . '\\' . $archivo->nombre_archivo;

        File::delete($path);

        $archivo->delete();

        return $this->showOne($archivo);
    }
}
