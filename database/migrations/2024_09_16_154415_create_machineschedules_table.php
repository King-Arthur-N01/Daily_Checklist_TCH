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
            $table->integer('schedule_duration');
            $table->timestamp('schedule_date');
            $table->timestamp('schedule_record')->nullable();
            $table->unsignedBigInteger('id_machine2')->nullable();
            $table->unsignedBigInteger('id_schedule2')->nullable();
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
        Schema::dropIfExists('machineschedules');
    }
}
