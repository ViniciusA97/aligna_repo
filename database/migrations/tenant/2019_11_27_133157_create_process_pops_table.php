<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessPopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_pops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('process_id')->unsigned();
            $table->bigInteger('pop_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('process_id')->references('id')->on('processes');
            $table->foreign('pop_id')->references('id')->on('pops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_pops');
    }
}
