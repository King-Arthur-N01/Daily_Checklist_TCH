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
            $table->string('machine_number')->nullable();
            $table->string('machine_name');
            $table->string('machine_brand')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('machine_spec')->nullable();
            $table->string('machine_power')->nullable();
            $table->string('machine_made')->nullable();
            $table->boolean('machine_status')->default(true);
            $table->string('machine_info')->nullable();
            $table->string('mfg_number')->index()->nullable();
            $table->string('install_date')->nullable();
            $table->string('production_date')->nullable();
            $table->boolean('machine_abnormal_status')->default(false);
            $table->string('machine_problem')->nullable();
            $table->string('machine_action')->default(false);
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('standart_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
