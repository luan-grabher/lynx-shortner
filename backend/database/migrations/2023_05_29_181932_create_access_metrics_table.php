<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('access_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->string('ip');
            $table->string('user_agent');
            $table->timestamps();

            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('access_metrics');
    }
}
