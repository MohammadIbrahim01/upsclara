<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->nullable();
            $table->float('gross_amount', 10, 2)->nullable();
            $table->float('discount_amount', 10, 2)->nullable();
            $table->float('net_amount', 10, 2)->nullable();
            $table->string('promo_code_applied')->nullable();
            $table->timestamps();
        });
    }
}
