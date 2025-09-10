<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCourseCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_course_category', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_10585083')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('course_category_id');
            $table->foreign('course_category_id', 'course_category_id_fk_10585083')->references('id')->on('course_categories')->onDelete('cascade');
        });
    }
}
