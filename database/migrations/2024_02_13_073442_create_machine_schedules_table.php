<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamp('schedule_start');
            $table->timestamp('schedule_end');
            $table->timestamp('schedule_next')->nullable();
            $table->integer('schedule_duration')->nullable();
            $table->timestamp('schedule_date')->nullable();
            $table->timestamp('schedule_record')->nullable();
            $table->boolean('machine_schedule_status')->default(false);
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('yearly_id');
            $table->unsignedBigInteger('monthly_id')->nullable();
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
        Schema::dropIfExists('machine_schedules');
    }
}
