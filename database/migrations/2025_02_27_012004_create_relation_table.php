<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\MockObject\Builder\Identity;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('componenchecks', function (Blueprint $table){
            $table->foreignId('id_property')->references('id')->on('machineproperties')->onDelete('cascade')->unique();
        });
        Schema::table( 'parameters',function(Blueprint $table){
            $table->foreignId('id_componencheck')->references('id')->on('componenchecks')->onDelete('cascade')->unique();
        });
        Schema::table('metodechecks', function (Blueprint $table){
            $table->foreignId('id_parameter')->references('id')->on('parameters')->onDelete('cascade')->unique();
        });
        Schema::table('machines', function (Blueprint $table){
            $table->foreign('property_id')->references('id')->on('machineproperties')->onDelete('set null');
        });
        Schema::table('machines', function (Blueprint $table){
            $table->foreign('standart_id')->references('id')->on('working_hours')->onDelete('set null');
        });


        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('correct_by')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('approve_by')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('monthly_id')->references('id')->on('monthly_schedules')->onDelete('set null');
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('special_id')->references('id')->on('monthly_schedules')->onDelete('set null');
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('yearly_id')->references('id')->on('yearly_schedules')->onDelete('cascade');
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('set null')->unique();
        });


        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_create')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_recognize')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_agreed')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('id_schedule_year')->references('id')->on('yearly_schedules')->onDelete('cascade')->unique();
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_create')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_recognize')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_agreed')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_planner')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation');
    }
}
