<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gomezapp')->create('reportes_movil', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_reporte');
            $table->string('img_reporte');
            $table->string('latitud'); //->unique();
            $table->string('longitud');
            $table->foreignId('idUsuario')->constrained('users','id');
            $table->string('referencia');
            $table->string('comentario');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gomezapp')->dropIfExists('reportes_movil');
    }
};
