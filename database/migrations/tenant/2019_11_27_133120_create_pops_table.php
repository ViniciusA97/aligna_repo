<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('recurrence_id')->nullable();
            $table->bigInteger('user_creator_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('recurrence_id')->references('id')->on('recurrences');
            // $table->foreign('user_creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pops');
    }
}
