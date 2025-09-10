<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment')->nullable();
            $table->string('transaction')->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
}
