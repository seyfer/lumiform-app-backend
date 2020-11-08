<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('term_id');
            $table->unsignedTinyInteger('final_score');
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('term_id')
                ->references('id')
                ->on('terms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
