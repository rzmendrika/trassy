<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restau_tarifs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedInteger('pictures');
            $table->unsignedInteger('menus');
            $table->unsignedInteger('monthly');
            $table->unsignedInteger('half_yearly');
            $table->unsignedInteger('yearly');
            $table->unsignedInteger('localisations');
            $table->boolean('events');
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
        Schema::dropIfExists('restau_tarifs');
    }
}
