<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table)
        {
            $table->id();

            $table->unsignedInteger('mode');
            $table->unsignedInteger('rub_type');
            $table->unsignedInteger('subscription');
            $table->string('reference');
            $table->date('ending');
            
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('tarif_id')->index();
            $table->timestamps();
        });

        // Schema::create('payment_rub', function (Blueprint $table)
        // {
        //     $table->id();

        //     $table->unsignedInteger('rub_type');
        //     $table->bigInteger('payment_id')->unsigned()->index();
        //     $table->bigInteger('rub_id')->unsigned()->index();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('payment_rub');
        Schema::dropIfExists('payments');
    }
}
