<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('price');
            $table->string('status');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('membership_id');
            $table->foreign('user_id', 'user_id_fk_1947072')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('membership_id', 'membership_id_fk_1947072')->references('id')->on('memberships')->onDelete('cascade');
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
        Schema::dropIfExists('payement');
    }
}
