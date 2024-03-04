<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponenchecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componenchecks', function (Blueprint $table) {
            $table->id();
            // $table->integer('machine_code_componencheck')->index();
            // $table->bigInteger('id_machine')->unique()->default('0');
            $table->string('name_componencheck');
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
        Schema::dropIfExists('componenchecks');
    }
}
