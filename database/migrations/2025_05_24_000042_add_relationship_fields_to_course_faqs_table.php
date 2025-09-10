<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('course_faqs', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_10584959')->references('id')->on('courses')->onDelete('cascade');
        });
    }
}
