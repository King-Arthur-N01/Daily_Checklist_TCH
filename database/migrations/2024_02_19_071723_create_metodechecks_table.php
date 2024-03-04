<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodechecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodechecks', function (Blueprint $table) {
            $table->id();
            // $table->integer('parameter_metodecheck')->index();
            // $table->bigInteger('id_parameter')->unique()->default('0');
            $table->string('name_metodecheck');
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
        Schema::dropIfExists('metodechecks');
    }
}
