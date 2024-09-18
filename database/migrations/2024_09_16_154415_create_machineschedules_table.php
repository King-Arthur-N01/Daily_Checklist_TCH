<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machineschedules', function (Blueprint $table) {
            $table->id();
            $table->timestamp('schedule_start');
            $table->timestamp('schedule_end');
            $table->timestamp('schedule_record')->nullable();
            $table->timestamp('schedule_next')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('finish_date')->nullable();
            $table->unsignedBigInteger('id_machine3')->nullable();
            $table->unsignedBigInteger('id_schedule')->nullable();
            $table->boolean('machineschedule_status')->default(false);
            $table->unsignedBigInteger('id_machinerecord')->nullable();
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
        Schema::dropIfExists('machineschedules');
    }
}
