<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoughtStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('bought_stocks', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->char('symbol', 10);
            $table->integer('amount');
            $table->float('bought');
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
        Schema::drop('bought_stocks');
    }
}
