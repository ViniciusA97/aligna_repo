<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pop_historics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pop_id')->unsigned();
            $table->bigInteger('recurrence_id')->nullable();

            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->double('hours', 12, 2);
            $table->enum('pdca', ['P - Planejamento', 'D - Execução', 'C - Conferência', 'A - Correção'])->nullable();
            $table->enum('perfil', ['Tático', 'Estratégico', 'Operacional'])->nullable();
            $table->enum('status', ['Está sendo executado', 'Está sendo parcialmente executado', 'Não está sendo executado', 'Em Construção', 'Desatualizado', 'Concluído', 'Inativo'])->nullable();

            $table->bigInteger('user_creator_id')->unsigned();
            $table->bigInteger('user_updated_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('pop_id')->references('id')->on('pops');
            // $table->foreign('recurrence_id')->references('id')->on('recurrences');
            // $table->foreign('user_creator_id')->references('id')->on('users');
            // $table->foreign('user_updated_by')->references('id')->on('users');
        });
        // Schema::table('pop_historics', function($table) {
        //     $table->foreign('pop_id')->references('id')->on('pops');
        //     $table->foreign('recurrence_id')->references('id')->on('recurrences');
        //     $table->foreign('user_creator_id')->references('id')->on('users');
        //     $table->foreign('user_updated_by')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pop_historics');
    }
}
