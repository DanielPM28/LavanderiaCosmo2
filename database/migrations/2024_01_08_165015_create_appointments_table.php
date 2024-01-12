<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('type');
            $table->string('direccion');

            //Conductor
            $table->unsignedBigInteger('conductor_id');
            $table->foreign('conductor_id')->references('id')->on('users')->onDelete('cascade');

             //Produccion
            $table->unsignedBigInteger('production_id');
            $table->foreign('production_id')->references('id')->on('users')->onDelete('cascade');

            //Produccion
            $table->unsignedBigInteger('producers_id');
            $table->foreign('producers_id')->references('id')->on('producers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
