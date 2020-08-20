<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('bed_numbers');
            $table->boolean('tv');
            $table->boolean('safe');    // Coffre fort
            $table->boolean('kitchen');
            
            $table->unsignedFloat('price')->default(0);

            $table->enum('shower', [0, 1, 2])->default(0); // non, oui, séparé
            $table->enum('wc',     [0, 1, 2])->default(0);
            
            $table->text('description')->nullable();

            $table->unsignedInteger('acc_id')->index();
            $table->unsignedInteger('category_id')->index();
            
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
        Schema::dropIfExists('rooms');
    }
}
