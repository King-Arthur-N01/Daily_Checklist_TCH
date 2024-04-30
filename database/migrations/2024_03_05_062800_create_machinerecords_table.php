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
            $table->integer('shift')->nullable();
            $table->string('note')->nullable();
            $table->integer('machine_number2')->index();
            $table->string('create_by')->nullable();
            $table->string('corrected_by')->nullable();
            $table->string('approve_by')->nullable();
            $table->timestamps('record_time');
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
