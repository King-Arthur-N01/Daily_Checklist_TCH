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
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('machine_number2')->identity('1,1')->references('machine_number')->on('machines')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('id_machineschedule')->identity('1,1')->references('id')->on('machineschedules')->onDelete('cascade');
        });
        // Schema::table('machinerecords', function (Blueprint $table){
        //     $table->foreign('id_machineschedule')->identity('1,1')->references('id')->on('machineschedules')->onDelete('cascade');
        // });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('correct_by')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreign('approve_by')->identity('1,1')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('machineschedules', function (Blueprint $table){
            $table->foreign('id_machine2')->identity('1,1')->references('id')->on('machines')->onDelete('cascade')->unique();
        });
        Schema::table('machineschedules', function (Blueprint $table){
            $table->foreign('id_schedule')->identity('1,1')->references('id')->on('schedules')->onDelete('cascade')->unique();
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
