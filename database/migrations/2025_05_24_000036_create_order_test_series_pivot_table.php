<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTestSeriesPivotTable extends Migration
{
    public function up()
    {
        Schema::create('order_test_series', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_10585046')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('test_series_id');
            $table->foreign('test_series_id', 'test_series_id_fk_10585046')->references('id')->on('test_seriess')->onDelete('cascade');
        });
    }
}
