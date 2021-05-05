<?php

namespace Database\Seeders;

use App\Models\Administracion\Rol;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::flushEventListeners();

        $archivo = File::get(storage_path('seeders/roles.json'));
        $roles = json_decode($archivo, true);

        foreach($roles as $rol) {
            DB::table(Rol::table)->insert([
                'descripcion' => $rol['descripcion'],
                'estado' => $rol['estado'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
