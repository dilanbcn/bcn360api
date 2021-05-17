<?php

use App\Models\Administracion\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Menu::table, function (Blueprint $table) {
            $table->id();
            $table->integer('padre_id')->unsigned()->nullable();
            $table->string('titulo');
            $table->string('ruta');
            $table->string('modelo');
            $table->boolean('estado')->default(true);

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
        Schema::dropIfExists(Menu::table);
    }
}
