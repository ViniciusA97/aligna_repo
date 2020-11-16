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
            $table->enum('role', ['Colaborador', 'Supervisor', 'Administrador', 'Inativo']);
            $table->string('foto_perfil')->nullable();
            $table->timestamp('data_nascimento')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->text('resumo_experiencia')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('id_setor')->nullable();
            $table->foreign('id_setor')->references('id')->on('setor')->onDelete('set null');
            $table->unsignedBigInteger('id_cargo')->nullable();
            $table->foreign('id_cargo')->references('id')->on('cargo')->onDelete('set null');
            $table->timestamp('send_last_invite')->nullable();
            $table->timestamp('last_access')->nullable();
        });
        Schema::enableForeignKeyConstraints();
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
