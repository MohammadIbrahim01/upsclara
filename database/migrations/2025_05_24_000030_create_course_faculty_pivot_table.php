<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseFacultyPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_faculty', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_10584697')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id', 'faculty_id_fk_10584697')->references('id')->on('faculties')->onDelete('cascade');
        });
    }
}
