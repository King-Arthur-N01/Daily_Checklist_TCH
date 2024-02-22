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
            $table->integer('id_componencheck1')->nullable();
            $table->integer('id_componencheck2')->nullable();
            $table->integer('id_componencheck3')->nullable();
            $table->integer('id_componencheck4')->nullable();
            $table->integer('id_componencheck5')->nullable();
            $table->integer('id_componencheck6')->nullable();
            $table->integer('id_componencheck7')->nullable();
            $table->integer('id_componencheck8')->nullable();
            $table->integer('id_componencheck9')->nullable();
            $table->integer('id_componencheck10')->nullable();
            $table->integer('id_componencheck11')->nullable();
            $table->integer('id_componencheck12')->nullable();
            $table->integer('id_parameter1')->nullable();
            $table->integer('id_parameter2')->nullable();
            $table->integer('id_parameter3')->nullable();
            $table->integer('id_parameter4')->nullable();
            $table->integer('id_parameter5')->nullable();
            $table->integer('id_parameter6')->nullable();
            $table->integer('id_parameter7')->nullable();
            $table->integer('id_parameter8')->nullable();
            $table->integer('id_parameter9')->nullable();
            $table->integer('id_parameter10')->nullable();
            $table->integer('id_parameter11')->nullable();
            $table->integer('id_parameter12')->nullable();
            $table->integer('id_metodecheck1')->nullable();
            $table->integer('id_metodecheck2')->nullable();
            $table->integer('id_metodecheck3')->nullable();
            $table->integer('id_metodecheck4')->nullable();
            $table->integer('id_metodecheck5')->nullable();
            $table->integer('id_metodecheck6')->nullable();
            $table->integer('id_metodecheck7')->nullable();
            $table->integer('id_metodecheck8')->nullable();
            $table->integer('id_metodecheck9')->nullable();
            $table->integer('id_metodecheck10')->nullable();
            $table->integer('id_metodecheck11')->nullable();
            $table->integer('id_metodecheck12')->nullable();
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
