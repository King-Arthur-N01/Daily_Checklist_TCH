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
            $table->string('problem')->nullable();
            $table->string('analysis')->nullable();
            $table->string('action')->nullable();
            $table->json('create_by')->nullable();
            $table->unsignedBigInteger('correct_by')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->json('operator_action');
            $table->json('result');
            $table->integer('machinerecord_status')->default(0);
            // $table->json('abnormal_record')->nullable();
            $table->timestamp('start_preventive')->nullable();
            $table->timestamp('finish_preventive')->nullable();
            $table->timestamp('record_date')->nullable();
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
