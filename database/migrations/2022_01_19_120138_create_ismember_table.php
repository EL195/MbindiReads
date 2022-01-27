<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ismember', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('expiration');
            $table->unsignedInteger('classe_id')->nullable();
            $table->unsignedInteger('membership_id');
            $table->unsignedInteger('student_id')->nullable();
            $table->foreign('classe_id', 'classe_id_fk_19444547072')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('student_id', 'student_id_fk_194744540472')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('membership_id', 'memberships_id_fk_19444470472')->references('id')->on('memberships')->onDelete('cascade');
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
        Schema::dropIfExists('ismember');
    }
}
