<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseContentsTable extends Migration
{
    public function up()
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->integer('sequence')->nullable();
            $table->timestamps();
        });
    }
}
