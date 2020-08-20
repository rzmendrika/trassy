<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restau_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('restau_restau_type', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restau_id')->unsigned()->index();
            $table->bigInteger('restau_type_id')->unsigned()->index();

            $table->foreign('restau_id')->references('id')->on('restaus')->onDelete('cascade');
            $table->foreign('restau_type_id')->references('id')->on('restau_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restau_restau_type');
        Schema::dropIfExists('restau_types');
    }
}
