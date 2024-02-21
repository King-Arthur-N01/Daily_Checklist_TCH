<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machineresults', function (Blueprint $table) {
            $table->id();
            $table->string('machine_code');
            $table->integer('id_componencheck1');
            $table->integer('id_componencheck2');
            $table->integer('id_componencheck3');
            $table->integer('id_componencheck4');
            $table->integer('id_componencheck5');
            $table->integer('id_componencheck6');
            $table->integer('id_parameter1');
            $table->integer('id_parameter2');
            $table->integer('id_parameter3');
            $table->integer('id_parameter4');
            $table->integer('id_parameter5');
            $table->integer('id_parameter6');
            $table->integer('id_metodecheck1');
            $table->integer('id_metodecheck2');
            $table->integer('id_metodecheck3');
            $table->integer('id_metodecheck4');
            $table->integer('id_metodecheck5');
            $table->integer('id_metodecheck6');
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
        Schema::dropIfExists('machineresults');
    }
}
