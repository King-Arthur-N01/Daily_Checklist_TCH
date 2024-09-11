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
            $table->string('shift')->nullable();
            $table->string('note')->nullable();
            $table->string('machine_number2')->index();
            $table->string('create_by')->nullable();
            $table->unsignedBigInteger('correct_by')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->unsignedBigInteger('id_machine2')->nullable();
            $table->unsignedBigInteger('id_schedule')->nullable();
            $table->boolean('status_record')->default(true);
            $table->json('abnormal_record')->nullable();
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
