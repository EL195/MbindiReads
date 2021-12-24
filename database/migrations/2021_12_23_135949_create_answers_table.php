<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('type')->nullable();
            $table->text('image')->nullable();
            $table->boolean('choose')->nullable();
            $table->unsignedInteger('quiz_id');
            $table->foreign('quiz_id', 'quiz_id_fk_1947072')->references('id')->on('quiz')->onDelete('cascade');
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
        Schema::dropIfExists('answers');
    }
}
