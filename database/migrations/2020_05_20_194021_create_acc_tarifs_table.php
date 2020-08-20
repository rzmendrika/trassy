<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_tarifs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedInteger('pictures');
            $table->unsignedInteger('monthly');
            $table->unsignedInteger('half_yearly');
            $table->unsignedInteger('yearly');
            $table->unsignedInteger('annexes');
            $table->boolean('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_tarifs');
    }
}
