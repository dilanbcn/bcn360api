<?php

use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use App\Models\Administracion\TipoArchivo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Archivo::table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('carpeta_id')->constrained(Carpeta::table);
            $table->foreignId('tipo_archivo_id')->constrained(TipoArchivo::table);
            $table->string('nombre');
            $table->string('ruta')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->string('nombre_descarga')->nullable();
            $table->boolean('privado')->default(true);
            $table->boolean('estado')->default(true);
            $table->boolean('declaracion')->nullable();
            $table->integer('creado_por')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Archivo::table);
    }
}
