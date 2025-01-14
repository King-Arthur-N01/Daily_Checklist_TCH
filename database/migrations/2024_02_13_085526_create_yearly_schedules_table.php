<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name_schedule_year');
            $table->string('schedule_year');
            // $table->json('machine_collection');
            $table->boolean('schedule_status')->default(false);
            $table->unsignedBigInteger('schedule_create')->nullable();
            $table->unsignedBigInteger('schedule_recognize')->nullable();
            $table->unsignedBigInteger('schedule_agreed')->nullable();
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
        Schema::dropIfExists('yearly_schedules');
    }
}
