<?php

namespace Database\Seeders;

use App\Models\Administracion\TipoArchivo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TipoArchivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoArchivo::flushEventListeners();

        $archivo = File::get(storage_path('seeders/tipo_archivos.json'));
        $tipos = json_decode($archivo, true);

        foreach($tipos as $tipo) {
            DB::table(TipoArchivo::table)->insert([
                'extension' => $tipo['extension'],
                'estado' => $tipo['estado'],
                'creado_por' => 1,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
