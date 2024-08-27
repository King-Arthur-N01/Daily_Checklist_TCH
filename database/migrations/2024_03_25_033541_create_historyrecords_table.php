<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @retuarn void
     */
    public function up()
    {
        Schema::create('historyrecords', function (Blueprint $table) {
            $table->id();
            $table->json('operator_action');
            $table->json('result');
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
        //
    }
}
