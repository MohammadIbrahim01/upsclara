<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->integer('sequence')->nullable();
            $table->string('group')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
