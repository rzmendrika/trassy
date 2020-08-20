<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restau_pictures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type');
            $table->string('path');

            $table->unsignedInteger('parent_id')->index();
            $table->unsignedInteger('child_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restau_pictures');
    }
}
