<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

class CreateMachinesTable extends Migration
{

    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('invent_number')->unique();
            $table->string('machine_number')->index();
            $table->string('machine_name');
            $table->string('machine_brand')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('machine_spec')->nullable();
            $table->string('machine_made')->nullable();
            $table->string('mfg_number');
            $table->string('install_date');
            $table->unsignedBigInteger('id_property')->nullable();
            $table->timestamp('schdule_1_month')->nullable();
            $table->timestamp('schdule_3_month')->nullable();
            $table->timestamp('schdule_6_month')->nullable();
            $table->timestamp('schdule_12_month')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
