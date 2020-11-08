<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->dateTime('last_used_at')->default(now());
            $table->timestamps();

            $table->index('term');
        });
    }

    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
