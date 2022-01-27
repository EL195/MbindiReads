<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('username');
            $table->integer('age');
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->unsignedInteger('langue_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('classe_id')->nullable();
            $table->foreign('langue_id', 'langue_id_fk_194445427072')->references('id')->on('langues')->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_1945427072')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('classe_id', 'classe_id_fk_1947072')->references('id')->on('classes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
