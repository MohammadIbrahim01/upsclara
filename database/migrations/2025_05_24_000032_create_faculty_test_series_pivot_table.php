<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyTestSeriesPivotTable extends Migration
{
    public function up()
    {
        Schema::create('faculty_test_series', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id', 'faculty_id_fk_10585081')->references('id')->on('faculties')->onDelete('cascade');
            $table->unsignedBigInteger('test_series_id');
            $table->foreign('test_series_id', 'test_series_id_fk_10585081')->references('id')->on('test_seriess')->onDelete('cascade');
        });
    }
}
