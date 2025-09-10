<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('experience')->nullable();
            $table->longText('qualifications')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
        });
    }
}
