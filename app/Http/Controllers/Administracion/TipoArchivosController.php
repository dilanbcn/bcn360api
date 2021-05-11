<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\TipoArchivoRequest;
use App\Models\Administracion\TipoArchivo;
use Illuminate\Http\Request;

class TipoArchivosController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoArchivos = TipoArchivo::all();

        return $this->showAll($tipoArchivos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoArchivoRequest $request)
    {
        $accion = TipoArchivo::create([
            'extension' => $request->get('extension'),
            'creado_por' => $request->get('creado_por'),
        ]);

        $accion->save();

        return $this->showOne($accion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\TipoArchivo  $tipoArchivo
     * @return \Illuminate\Http\Response
     */
    public function show(TipoArchivo $tipoArchivo)
    {
        return $this->showOne($tipoArchivo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\TipoArchivo  $tipoArchivo
     * @return \Illuminate\Http\Response
     */
    public function update(TipoArchivoRequest $request, TipoArchivo $tipoArchivo)
    {
        $tipoArchivo->fill($request->only([
            'extension',
            'creado_por',
            'estado',
        ]));

        return $this->showOne($tipoArchivo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\TipoArchivo  $tipoArchivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoArchivo $tipoArchivo)
    {
        $tipoArchivo->delete();

        return $this->showOne($tipoArchivo);
    }
}
