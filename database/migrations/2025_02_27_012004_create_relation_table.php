<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('componenchecks', function (Blueprint $table){
            $table->foreign('machine_code_componencheck')->references('machine_code')->on('machines')->onDelete('cascade');
        });
        Schema::table( 'parameters',function(Blueprint $table){
            $table->foreign('componencheck_parameter')->references('id_componencheck')->on('componenchecks')->onDelete('cascade');
        });
        Schema::table('metodechecks', function (Blueprint $table){
            $table->foreign('parameter_metodecheck')->references('id_parameter')->on('parameters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation');
    }
}
