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
        Schema::connection("mysql_cove")->create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_number');
            $table->foreignId('brand_id')->constrained('brands','id');
            $table->foreignId('model_id')->constrained('models','id');
            $table->integer('year');
            $table->date('registration_date');
            $table->string('description')->nullable();
            $table->string('plates')->comment('placas asignadas al carro');
            $table->foreignId('vehicle_status_id')->constrained('vehicle_status','id');
            $table->string('img_path')->nullable();
            $table->string('description')->nullable();
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
        Schema::connection('mysql_cove')->dropIfExists('vehicles');
    }
};
