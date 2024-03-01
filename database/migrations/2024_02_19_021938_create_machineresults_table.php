<?php

use App\Machineresult;
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
            $table->integer('machine_coderesult')->index();
            $table->integer('id_componencheck1')->nullable();
            $table->integer('id_parameter1')->nullable();
            $table->integer('id_metodecheck1')->nullable();
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
