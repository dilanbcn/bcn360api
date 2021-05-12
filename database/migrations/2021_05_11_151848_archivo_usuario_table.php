<?php

use App\Models\Administracion\Archivo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArchivoUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivo_usuario', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned();
            $table->foreignId('archivo_id')->constrained(Archivo::table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivo_usuario');
    }
}
