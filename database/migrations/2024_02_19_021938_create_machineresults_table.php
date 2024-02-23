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
            $table->string('machine_code')->index();
            $table->string('id_componencheck1')->nullable();
            $table->string('id_componencheck2')->nullable();
            $table->string('id_componencheck3')->nullable();
            $table->string('id_componencheck4')->nullable();
            $table->string('id_componencheck5')->nullable();
            $table->string('id_componencheck6')->nullable();
            $table->string('id_componencheck7')->nullable();
            $table->string('id_componencheck8')->nullable();
            $table->string('id_componencheck9')->nullable();
            $table->string('id_componencheck10')->nullable();
            $table->string('id_componencheck11')->nullable();
            $table->string('id_componencheck12')->nullable();
            $table->string('id_parameter1')->nullable();
            $table->string('id_parameter2')->nullable();
            $table->string('id_parameter3')->nullable();
            $table->string('id_parameter4')->nullable();
            $table->string('id_parameter5')->nullable();
            $table->string('id_parameter6')->nullable();
            $table->string('id_parameter7')->nullable();
            $table->string('id_parameter8')->nullable();
            $table->string('id_parameter9')->nullable();
            $table->string('id_parameter10')->nullable();
            $table->string('id_parameter11')->nullable();
            $table->string('id_parameter12')->nullable();
            $table->string('id_metodecheck1')->nullable();
            $table->string('id_metodecheck2')->nullable();
            $table->string('id_metodecheck3')->nullable();
            $table->string('id_metodecheck4')->nullable();
            $table->string('id_metodecheck5')->nullable();
            $table->string('id_metodecheck6')->nullable();
            $table->string('id_metodecheck7')->nullable();
            $table->string('id_metodecheck8')->nullable();
            $table->string('id_metodecheck9')->nullable();
            $table->string('id_metodecheck10')->nullable();
            $table->string('id_metodecheck11')->nullable();
            $table->string('id_metodecheck12')->nullable();
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
