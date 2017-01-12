<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('sold_stocks', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->char('symbol', 10);
            $table->integer('amount');
            $table->float('sold');
            $table->float('from');
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
        Schema::drop('sold_stocks');
    }
}
