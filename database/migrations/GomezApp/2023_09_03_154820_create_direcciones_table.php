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
        Schema::connection('mysql_gomezapp')->create('direcciones_reportes', function (Blueprint $table) {
            $table->id();
            $table->string('calleNum');
            $table->string('cp');
            $table->string('colonia');
            $table->string('localidad');
            $table->string('municipio');
            $table->string('estado');
            $table->string('referencias');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gomezapp')->dropIfExists('direcciones_reportes');
    }
};
