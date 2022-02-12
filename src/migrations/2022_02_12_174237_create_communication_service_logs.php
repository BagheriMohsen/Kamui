<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('communication_service_logs', function (Blueprint $table) {
            $table->id();
            $table->string('driver');
            $table->longText('payload');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('communication_service_logs');
    }
};
