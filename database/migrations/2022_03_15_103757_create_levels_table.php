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
            \Illuminate\Support\Facades\DB::statement('SET SESSION sql_require_primary_key=0');
            $table->id();
            $table->char('name', 50);
            $table->foreignId('user_id')->references('id')->on('users')->nullable();
            $table->integer('lives');
            $table->integer('digsideers');
            $table->integer('digdowners');
            $table->integer('stopperers');
            $table->integer('umbrellaers');
            $table->integer('stairers');
            $table->integer('climbers');
            $table->mediumText('scene');
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
