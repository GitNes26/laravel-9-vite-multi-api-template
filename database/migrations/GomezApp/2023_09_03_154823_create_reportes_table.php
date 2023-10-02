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
        Schema::connection('mysql_gomezapp')->create('reportes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_reporte');
            $table->string('img_reporte');
            $table->integer('folio');
            $table->string('latitud')->nullable(); //->unique();
            $table->string('longitud')->nullable();
            $table->foreignId('id_user')->constrained('users','id');
            $table->string('calleNum')->nullable();
            $table->string('cp')->nullable();
            $table->string('colonia')->nullable();
            $table->string('localidad')->nullable()->default('Gómez Palacio');
            $table->string('municipio')->nullable()->default('Gómez Palacio');
            $table->string('estado')->nullable()->default('Durango');
            $table->string('referencias')->nullable();
            $table->foreignId('id_tipo_reporte')->constrained('tipos_reportes','id');  //DEPARTAMENTO
            $table->foreignId('id_origen')->constrained('origen_reporte','id')->default(1); //WEB, APP, TELEFONICO ETC
            $table->foreignId('id_estatus')->constrained('estatus','id')->default(1);   // ASIGANDO, EN CURSO, ATENDIDO ETC
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
        Schema::connection('mysql_gomezapp')->dropIfExists('reportes');
    }
};
