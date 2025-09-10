<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('course_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('course_category_id')->nullable();
            $table->foreign('course_category_id', 'course_category_fk_10584615')->references('id')->on('course_categories')->onDelete('set null');
        });
    }
}
