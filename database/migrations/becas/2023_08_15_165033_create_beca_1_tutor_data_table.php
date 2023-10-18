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
        Schema::connection("mysql_becas")->create('beca_1_tutor_data', function (Blueprint $table) {
            $table->id();
            $table->string('relationship')->comment("parentesco con el alumno");
            $table->string('curp');
            $table->string('name');
            $table->string('paternal_last_name');
            $table->string('maternal_last_name');
            // $table->boolean('single_mother')->nullable();
            $table->string('ine_path')->nullable();
            $table->string('power_letter_path')->nullable();
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
        Schema::connection('mysql_becas')->dropIfExists('beca_1_tutor_data');
    }
};