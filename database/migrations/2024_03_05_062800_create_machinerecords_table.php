<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinerecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinerecords', function (Blueprint $table) {
            $table->id();
            $table->string('operator_action');
            $table->integer('shift')->nullable();
            $table->string('result');
            $table->string('note')->nullable();
            $table->integer('machine_number');
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
        Schema::dropIfExists('machinerecords');
    }
}
