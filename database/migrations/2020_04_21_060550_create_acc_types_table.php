<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });


        Schema::create('acc_acc_type', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('acc_id')->unsigned()->index();
            $table->bigInteger('acc_type_id')->unsigned()->index();

            $table->foreign('acc_id')->references('id')->on('accs')->onDelete('cascade');
            $table->foreign('acc_type_id')->references('id')->on('acc_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_acc_type');
        Schema::dropIfExists('acc_types');
    }
}
