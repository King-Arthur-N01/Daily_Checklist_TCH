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
            $table->foreignId('id_property2')->identity('1,1')->references('id')->on('machineproperties')->onDelete('cascade')->unique();
        });
        Schema::table( 'parameters',function(Blueprint $table){
            $table->foreignId('id_componencheck')->Identity('1,1')->references('id')->on('componenchecks')->onDelete('cascade')->unique();
        });
        Schema::table('metodechecks', function (Blueprint $table){
            $table->foreignId('id_parameter')->identity('1,1')->references('id')->on('parameters')->onDelete('cascade')->unique();
        });
        Schema::table('machines', function (Blueprint $table){
            $table->foreign('id_property')->identity('1,1')->references('id')->on('machineproperties')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('id_machine_schedule')->identity('1,1')->references('id')->on('machine_schedules')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('correct_by')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('approve_by')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('id_schedule_year')->identity('1,1')->references('id')->on('yearly_schedules')->onDelete('cascade')->unique();
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('monthly_id')->identity('1,1')->references('id')->on('monthly_schedules')->onDelete('cascade');
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('yearly_id')->identity('1,1')->references('id')->on('yearly_schedules')->onDelete('cascade');
        });
        Schema::table('machine_schedules', function (Blueprint $table){
            $table->foreign('machine_id')->identity('1,1')->references('id')->on('machines')->onDelete('cascade')->unique();
        });
        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_create')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_recognize')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('yearly_schedules', function (Blueprint $table){
            $table->foreign('schedule_agreed')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_create')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_recognize')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('monthly_schedules', function (Blueprint $table){
            $table->foreign('schedule_agreed')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
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
