<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineScheduleMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_schedule_months', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_duration');
            $table->timestamp('schedule_date');
            $table->timestamp('schedule_record')->nullable();
            $table->unsignedBigInteger('id_schedule_month')->nullable();
            $table->unsignedBigInteger('id_machine_schedule_year')->nullable();
            $table->boolean('machineschedule_status')->default(false);
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
        Schema::dropIfExists('machine_schedule_months');
    }
}
