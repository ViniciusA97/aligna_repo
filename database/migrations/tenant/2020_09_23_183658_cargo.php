<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cargo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('resumo')->nullable(false);
            $table->text('descricao')->nullable(true);
            $table->boolean('active')->nullable(false)->default(1);
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
