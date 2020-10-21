<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pop_id')->nullable();
            $table->bigInteger('user_id')->unsigned();

            $table->string('title', 255)->nullable();
            $table->string('filename', 120);
            $table->string('external_url', 255);
            $table->string('external_bucket', 255)->nullable();
            $table->string('external_endpoint', 255)->nullable();
            $table->string('provider', 120)->nullable();
            $table->string('mine', 120)->nullable();
            $table->string('extension', 20)->nullable();
            $table->integer('size')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
