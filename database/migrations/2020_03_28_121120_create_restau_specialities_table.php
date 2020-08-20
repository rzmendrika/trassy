<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restau_specialities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('restau_restau_speciality', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restau_id')->unsigned()->index();
            $table->bigInteger('restau_speciality_id')->unsigned()->index();

            $table->foreign('restau_id')
                ->references('id')
                ->on('restaus')
                ->onDelete('cascade');

            $table->foreign('restau_speciality_id')
                    ->references('id')
                    ->on('restau_specialities')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restau_restau_speciality');
        Schema::dropIfExists('restau_specialities');
    }
}
