<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Models\Administracion\Carpeta;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $carpeta = Carpeta::create([
            'nombre' => $request->get('nombre'),
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
    public function update(Request $request, Carpeta $carpeta)
    {
        $carpeta->fill($request->all());

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
        $carpeta->delete();

        return $this->showOne($carpeta);
    }
}
