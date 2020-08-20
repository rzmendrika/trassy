<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestausTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaus', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('days', 20)->default('1,2,3,4,5');
            $table->boolean('parking')->default(false);
            $table->boolean('delivery')->default(false);
            $table->boolean('wifi')->default(false);
            $table->time('opening')->default('08:00');
            $table->time('closing')->default('20:00');
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
            $table->text('description')->nullable();

            $table->integer('likes')->default(0);
            $table->boolean('active')->default(false);  //  à afficher ou non un restau

            $table->timestamps();

            $table->integer('user_id')->unsigned()->index();
            $table->integer('payment_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaus');
    }
}
