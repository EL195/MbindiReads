<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('classe_id')->nullable();
            $table->unsignedInteger('membership_id');
            $table->foreign('classe_id', 'classe_id_fk_19470472')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('student_id', 'student_id_fk_19470472')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('membership_id', 'memberships_id_fk_19470472')->references('id')->on('memberships')->onDelete('cascade');
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
        Schema::dropIfExists('subscriptions');
    }
}
