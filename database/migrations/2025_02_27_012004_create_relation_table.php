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
            $table->foreignId('id_machine')->identity('1,1')->references('id')->on('machines')->onDelete('cascade')->unique();
        });
        Schema::table( 'parameters',function(Blueprint $table){
            $table->foreignId('id_componencheck')->Identity('1,1')->references('id')->on('componenchecks')->onDelete('cascade')->unique();
        });
        Schema::table('metodechecks', function (Blueprint $table){
            $table->foreignId('id_parameter')->identity('1,1')->references('id')->on('parameters')->onDelete('cascade')->unique();
        });
        Schema::table('machinerecords', function (Blueprint $table){
            $table->foreignId('id_machinerecord')->identity('1,1')->references('id')->on('machines')->onDelete('cascade')->unique();
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
