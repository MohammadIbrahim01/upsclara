<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question')->nullable();
            $table->longText('answer')->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
