<?php

namespace Database\Seeders;

use App\Models\Administracion\Ruta;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RutasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ruta::flushEventListeners();

        $archivo = File::get(storage_path('seeders/rutas.json'));
        $rutas = json_decode($archivo, true);

        foreach($rutas as $ruta) {
            DB::table(Ruta::table)->insert([
                'nombre' => $ruta['nombre'],
                'descripcion' => $ruta['descripcion'],
                'estado' => $ruta['estado'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
