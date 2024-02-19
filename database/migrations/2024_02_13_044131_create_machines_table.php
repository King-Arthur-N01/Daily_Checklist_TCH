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
            $table->integer('machine_code');
            $table->string('machine_name');
            $table->string('machine_brand');
            $table->string('machine_type');
            $table->string('machine_spec');
            $table->string('mfg_number');
            $table->string('invent_number');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
