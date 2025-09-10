<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('heading');
            $table->string('slug')->unique();
            $table->string('sub_heading')->nullable();
            $table->string('language')->nullable();
            $table->string('duration')->nullable();
            $table->string('video_lectures')->nullable();
            $table->string('questions_count')->nullable();
            $table->datetime('enrolment_deadline_date')->nullable();
            $table->integer('price')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('extra_content')->nullable();
            $table->string('featured_image_caption')->nullable();
            $table->boolean('featured')->default(0)->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->integer('sequence')->nullable();
            $table->timestamps();
        });
    }
}
