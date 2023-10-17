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
            $table->foreignId('tutor_id')->constrained('users', 'id');
            $table->string('tutor_full_name');
            $table->string('tutor_phone');
            $table->boolean('single_mother')->nullable();

            $table->foreignId('student_data_id')->constrained('beca_1_student_data', 'id');
            $table->foreignId('school_id')->constrained('schools', 'id')->nullable();
            $table->integer('grade')->nullable();
            $table->decimal('average', 8, 2)->nullable();

            $table->decimal('extra_income', 11, 2)->nullable();
            $table->decimal('monthly_income', 11, 2)->nullable();

            $table->decimal('total_expenses', 11, 2)->nullable();

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