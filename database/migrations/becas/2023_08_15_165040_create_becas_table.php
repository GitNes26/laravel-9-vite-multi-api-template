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
        Schema::connection("mysql_becas")->create('becas', function (Blueprint $table) {
            $table->id();
            $table->integer('folio');
            $table->string('tutor_full_name');
            $table->string('tutor_phone');
            $table->boolean('single_mother')->nullable();

            $table->foreignId('student_id')->constrained('student_data', 'id');

            $table->foreignId('school_id')->constrained('schools', 'id');
            $table->integer('grade');
            $table->decimal('average', 3, 2);
            $table->text('comments')->nullable();

            $table->enum('socioeconomic_study', ['BAJO', 'MEDIO-BAJO', 'NORMAL'])->nullable();

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
        Schema::connection('mysql_becas')->dropIfExists('becas');
    }
};
