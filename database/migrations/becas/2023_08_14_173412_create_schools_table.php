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
        Schema::connection('mysql_becas')->create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('level_id')->constrained('levels', 'id');
            $table->string('school', 100);
            $table->integer('community_id')->comment('este dato viene de una api externa brindando de estado hasta colonia');
            $table->foreignId('city_id')->constrained('cities', 'id');
            $table->foreignId('colony_id')->constrained('colonies', 'id');
            $table->string('address');
            $table->string('phone')->default('S/N');
            $table->string('director');
            $table->boolean('loc_for', 1)->default(1)->comment("booleano para saber si la escuela es local=1 o foranea=0.");
            $table->enum('zone', ['U', 'R']);
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
        Schema::connection('mysql_becas')->dropIfExists('schools');
    }
};
