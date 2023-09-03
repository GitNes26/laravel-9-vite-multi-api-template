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
        Schema::connection('mysql_cove')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email'); //->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles','id');
            $table->string('tel');
            $table->string('license_number');
            $table->string('payroll_number');
            $table->foreignId('department_id')->constrained('departments','id');

            $table->string('name')->nullable();
            $table->string('paternal_last_name')->nullable();
            $table->string('maternal_last_name')->nullable();
            $table->foreignId('municipality_id')->constrained('municipalities','id');
            $table->foreignId('colony_id')->constrained('colonies','id');
            $table->string('address')->nullable();
            // $table->string('image')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('active')->default(true);
            $table->rememberToken();
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
        Schema::connection('mysql_cove')->dropIfExists('users');
    }
};
