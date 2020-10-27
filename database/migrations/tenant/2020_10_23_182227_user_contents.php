<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Colaborador', 'Supervisor', 'Administrador', 'Inativo'])->nullable();
            $table->string('foto_perfil')->nullable();
            $table->timestamp('data_nascumento')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->text('resumo_experiencia')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamp('send_last_invite')->nullable();
            $table->timestamp('last_access')->nullable();
            $table->bigInteger('id_setor')->unsigned()->nullable();
            $table->bigInteger('id_cargo')->unsigned()->nullable();
            $table->foreign('id_setor')->references('id')->on('setor');
            $table->foreign('id_cargo')->references('id')->on('cargo');
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
