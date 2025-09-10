<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOpeningsTable extends Migration
{
    public function up()
    {
        Schema::create('job_openings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('location')->nullable();
            $table->longText('content')->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
