<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseOrderPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_order', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_10585045')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_10585045')->references('id')->on('courses')->onDelete('cascade');
        });
    }
}
