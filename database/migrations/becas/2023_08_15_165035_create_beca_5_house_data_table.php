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
        Schema::connection("mysql_becas")->create('beca_5_household_equipment_data', function (Blueprint $table) {
            $table->id();
            $table->integer("beca_id");
            $table->int('beds');
            $table->int('washing_machines');
            $table->int('boilers');
            $table->int('tvs');
            $table->int('pcs');
            $table->int('music_player');
            $table->int('stoves');
            $table->int('refrigerators');

            $table->boolean('drinking_water');
            $table->boolean('electric_light');
            $table->boolean('sewer_system');
            $table->boolean('pavement');
            $table->boolean('automobile');
            $table->boolean('phone_line');
            $table->boolean('internet');            

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
        Schema::connection('mysql_becas')->dropIfExists('beca_5_household_equipment_data');
    }
};