<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('othercharge_info', 200);
            $table->decimal('cost', 8, 2);
            $table->unsignedInteger('billing_id');
            $table->foreign('billing_id')
                ->references('id')
                ->on('billings');
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
        Schema::dropIfExists('othercharges');
    }
}
