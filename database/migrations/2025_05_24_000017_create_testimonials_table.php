<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sub_heading')->nullable();
            $table->longText('content');
            $table->string('caption')->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
