<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHaveawardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haveawards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('award_id')->nullable();
            $table->foreign('student_id', 'student_id_fk_19444374444540472')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('award_id', 'award_id_fk_1947444434540472')->references('id')->on('awards')->onDelete('cascade');
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
        Schema::dropIfExists('haveawards');
    }
}
