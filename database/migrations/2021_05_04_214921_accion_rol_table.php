<?php

use App\Models\Administracion\Accion;
use App\Models\Administracion\Rol;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccionRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accion_rol', function (Blueprint $table) {

            $table->foreignId('accion_id')->constrained(Accion::table);
            $table->foreignId('rol_id')->constrained(Rol::table);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accion_rol');
    }
}
