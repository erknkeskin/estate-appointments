<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('home_id')->unsigned()->default(0);
            $table->string('title');
            $table->text('note');
            $table->integer('start');
            $table->timestamps();
            $table->integer('status')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
