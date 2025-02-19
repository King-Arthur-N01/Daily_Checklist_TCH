<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name_schedule_month');
            $table->json('schedule_collection')->nullable();
            $table->boolean('schedule_status')->default(false);
            $table->boolean('schedule_special')->default(false);
            $table->unsignedBigInteger('schedule_create')->nullable();
            $table->unsignedBigInteger('schedule_recognize')->nullable();
            $table->unsignedBigInteger('schedule_agreed')->nullable();
            $table->unsignedBigInteger('schedule_planner')->nullable();
            $table->unsignedBigInteger('id_schedule_year')->nullable();
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
        Schema::dropIfExists('monthly_schedules');
    }
}
