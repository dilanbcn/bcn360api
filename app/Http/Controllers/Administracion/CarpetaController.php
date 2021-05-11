<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CarpetaRequest;
use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str as Str;

class CarpetaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carpetas = Carpeta::all();

        return $this->showAll($carpetas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarpetaRequest $request)
    {

        $carpeta = Carpeta::create([
            'nombre' => $request->get('nombre'),
            'padre_id' => $request->get('padre'),
            'path' => $this->obtenerPath($request),
            'creado_por' => $request->get('creado_por'),
        ]);

        $carpeta->save();

        return $this->showOne($carpeta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\Carpeta  $carpeta
     * @return \Illuminate\Http\Response
     */
    public function show(Carpeta $carpeta)
    {
        return $this->showOne($carpeta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Carpeta  $carpeta
     * @return \Illuminate\Http\Response
     */
    public function update(CarpetaRequest $request, Carpeta $carpeta)
    {

        $carpeta->fill($request->only([
            'nombre',
            'creado_por',
            'estado'
        ]));

        $destino = $this->obtenerPath($request, $carpeta);

        $cearpetaEliminar = "";
        if ($destino != $carpeta->path) {
            $directorioRaiz = public_path(config('app.archivos_url'));
            $cearpetaEliminar = $directorioRaiz.$carpeta->path;
            
        }


        $carpeta->padre_id = ($request->has('padre')) ? $request->get('padre') : $carpeta->padre_id;
        $carpeta->path = $destino;

        if (Archivo::where(['carpeta_id' => $carpeta->id])->count() > 0) {
            $this->moverArchivos($carpeta->id, $destino);

            if ($cearpetaEliminar) {
                File::deleteDirectory($cearpetaEliminar);
            }
        }

        

        $carpeta->save();

        return $this->showOne($carpeta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Carpeta  $carpeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carpeta $carpeta)
    {

        if (Archivo::where(['carpeta_id' => $carpeta->id])->count() > 0) {
            return $this->errorResponse('No se puede eliminar la carpeta porque hay archivos que dependen de ella', 404);
        }

        $carpeta->delete();

        return $this->showOne($carpeta);
    }
}
