<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('heading')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image_caption')->nullable();
            $table->string('type')->nullable();
            $table->date('publish_date')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
