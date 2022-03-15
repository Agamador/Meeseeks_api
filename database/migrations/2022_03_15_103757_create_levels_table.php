<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->integer('lives');
            $table->integer('digsideers');
            $table->integer('digdowners');
            $table->integer('stopperers');
            $table->integer('umbrellaers');
            $table->integer('stairers');
            $table->integer('climbers');
            $table->text('scene');
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
        Schema::dropIfExists('levels');
    }
}
