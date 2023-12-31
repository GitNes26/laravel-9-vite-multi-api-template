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
        Schema::connection('mysql_becas')->create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('name')->nullable();
            // $table->string('last_name')->nullable();
            // $table->string('image')->nullable();
            $table->string('email'); //->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('username');
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles','id');
            // $table->string('phone')->nullable();
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
        Schema::connection('mysql_becas')->dropIfExists('users');
    }
};