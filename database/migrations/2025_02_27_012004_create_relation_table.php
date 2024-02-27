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
        // Schema::create('relation', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        Schema::table('machineresults', function (Blueprint $table){
            $table->foreign('machine_coderesult')->references('machine_code')->on('machines')->onDelete('cascade');
            $table->foreign( 'id_componencheck1' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck2' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck3' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck4' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck5' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck6' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck7' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck8' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck9' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck10' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck11' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_componencheck12' )->references('id_componencheck') ->on('componenchecks')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter1' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter2' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter3' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter4' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter5' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter6' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter7' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter8' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter9' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter10' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter11' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_parameter12' )->references('id_parameter') ->on('parameters')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck1' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck2' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck3' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck4' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck5' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck6' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck7' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck8' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck9' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck10' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck11' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
            $table->foreign( 'id_metodecheck12' )->references('id_metodecheck') ->on('metodechecks')->onDelete( 'cascade' );
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
