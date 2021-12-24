<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('file');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('author')->nullable();
            $table->string('published_date')->nullable();
            $table->integer('pages_number')->nullable();
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('genre_id');
            $table->unsignedInteger('theme_id');
            $table->unsignedInteger('agegroup_id');
            $table->foreign('level_id', 'level_id_fk_1947072')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('subject_id', 'subject_id_fk_1947072')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('genre_id', 'genre_id_fk_1947072')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('theme_id', 'theme_id_fk_1947072')->references('id')->on('themes')->onDelete('cascade');
            $table->foreign('agegroup_id', 'agegroup_id_fk_1947072')->references('id')->on('agegroup')->onDelete('cascade');
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
        Schema::dropIfExists('ressources');
    }
}
