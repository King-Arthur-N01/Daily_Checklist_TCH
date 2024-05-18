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
            $table->unsignedBigInteger('reject_by')->nullable();
            $table->unsignedBigInteger('create_by')->nullable();
            $table->unsignedBigInteger('correct_by')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->timestamp('record_time')->nullable();
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
