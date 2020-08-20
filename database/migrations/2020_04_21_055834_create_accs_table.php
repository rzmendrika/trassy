<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accs', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->smallInteger('stars')->unsigned()->nullable();
            $table->string('days', 20)->default('1,2,3,4,5,6,7');
            $table->boolean('parking')->default(0);
            $table->boolean('wifi')->default(0);
            $table->boolean('playground')->default(0);
            $table->boolean('roomservice')->default(0);
            $table->boolean('principal')->default(0);
            $table->text('description')->nullable();

            $table->integer('likes')->default(0);
            $table->integer('visites')->default(0);
            $table->string('active')->default('false')->nullable();

            $table->integer('user_id')->unsigned()->index();
            $table->integer('payment_id')->unsigned()->index();

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
        Schema::dropIfExists('accs');
    }
}
