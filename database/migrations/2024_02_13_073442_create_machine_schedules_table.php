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
            $table->timestamp('schedule_start')->nullable();
            $table->timestamp('schedule_end')->nullable();
            $table->integer('preventive_cycle')->nullable();
            $table->timestamp('schedule_date')->nullable();
            $table->timestamp('reschedule_date_1')->nullable();
            $table->timestamp('reschedule_date_2')->nullable();
            $table->timestamp('reschedule_date_3')->nullable();
            $table->string('reschedule_note')->nullable();
            $table->timestamp('schedule_record')->nullable();
            $table->integer('machine_schedule_status')->default(0);
            $table->boolean('schedule_time_status')->nullable();
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('yearly_id');
            $table->unsignedBigInteger('monthly_id')->nullable();
            $table->unsignedBigInteger('record_repair_id')->nullable();
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
