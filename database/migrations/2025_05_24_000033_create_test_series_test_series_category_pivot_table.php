<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSeriesTestSeriesCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('test_series_test_series_category', function (Blueprint $table) {
            $table->unsignedBigInteger('test_series_id');
            $table->foreign('test_series_id', 'test_series_id_fk_10584754')->references('id')->on('test_seriess')->onDelete('cascade');
            $table->unsignedBigInteger('test_series_category_id');
            $table->foreign('test_series_category_id', 'test_series_category_id_fk_10584754')->references('id')->on('test_series_categories')->onDelete('cascade');
        });
    }
}
