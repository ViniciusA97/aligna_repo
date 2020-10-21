<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPopHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pop_historics', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->string('resume', 200)->nullable();
            $table->enum('status_preenchimento', ['Em construção', 'Desatualizado', 'Concluído', 'Inativo'])->nullable();
            $table->enum('status_execucao', ['Está sendo executado', 'Está sendo parcialmente executado', 'Não está sendo executado'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pop_historics', function (Blueprint $table) {
            //
        });
    }
}
