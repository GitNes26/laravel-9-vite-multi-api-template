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
            $table->integer('folio');
            $table->string('latitud'); //->unique();
            $table->string('longitud');
            $table->foreignId('id_user')->constrained('users','id');
            $table->foreignId('id_tipo_reporte')->constrained('tipos_reportes','id');
            $table->foreignId('id_direccion')->constrained('direcciones_reportes','id');
            $table->foreignId('id_origen')->constrained('origen_reporte','id')->default(1);
            $table->foreignId('id_estatus')->constrained('estatus','id')->default(1);
            $table->foreignId('id_servicio')->constrained('servicios','id')->default(1);
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
