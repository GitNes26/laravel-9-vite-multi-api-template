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
        Schema::connection('mysql_imm')->create('expendents', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('procceding_id')->constrained('user_proceedings','id');
            $table->foreignId('type_violences_id')->constrained('expendent_type_violences','id');
            $table->foreignId('motive_closed_id')->constrained('expendent_motive_closeds','id');
            $table->foreignId('problems_id')->constrained('expendent_problems','id');
            $table->string('diagnostic');
            $table->date('dateclosed');

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
        Schema::connection('mysql_imm')->dropIfExists('expendents');
    }
};
