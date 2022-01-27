<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('ressource_id');
            $table->foreign('student_id', 'student_id_fk_19345470472')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('ressource_id', 'ressource_id_fk_19470472')->references('id')->on('ressources')->onDelete('cascade');
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
        Schema::dropIfExists('reading');
    }
}
