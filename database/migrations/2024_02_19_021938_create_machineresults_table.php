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
            $table->bigInteger('id_componencheck1');
            $table->bigInteger('id_componencheck2');
            $table->bigInteger('id_componencheck3');
            $table->bigInteger('id_componencheck4');
            $table->bigInteger('id_componencheck5');
            $table->bigInteger('id_componencheck6');
            $table->bigInteger('id_parameter1');
            $table->bigInteger('id_parameter2');
            $table->bigInteger('id_parameter3');
            $table->bigInteger('id_parameter4');
            $table->bigInteger('id_parameter5');
            $table->bigInteger('id_parameter6');
            $table->bigInteger('id_metodecheck1');
            $table->bigInteger('id_metodecheck2');
            $table->bigInteger('id_metodecheck3');
            $table->bigInteger('id_metodecheck4');
            $table->bigInteger('id_metodecheck5');
            $table->bigInteger('id_metodecheck6');
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
