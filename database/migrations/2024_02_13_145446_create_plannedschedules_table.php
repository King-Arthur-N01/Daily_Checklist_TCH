<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannedschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannedschedules', function (Blueprint $table) {
            $table->id();
            $table->timestamp('schedule_start')->nullable();
            $table->timestamp('schedule_end')->nullable();
            $table->timestamp('schedule_next')->nullable();
            $table->boolean('schedule_status')->default(false);
            $table->unsignedBigInteger('id_machine')->nullable();
            $table->unsignedBigInteger('id_schedule')->nullable();
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
        Schema::dropIfExists('plannedschedules');
    }
}