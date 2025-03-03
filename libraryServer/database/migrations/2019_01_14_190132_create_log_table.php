<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('iduser');
            $table->foreign('iduser')->references('id')->on('users');
//            $table->unsignedInteger('idcatalog');
//            $table->foreign('idtitles')->references('idtitles')->on('titles');
            $table->unsignedInteger('eventtype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}
