<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTestSeriesCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('test_series_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('test_series_category_id')->nullable();
            $table->foreign('test_series_category_id', 'test_series_category_fk_10584762')->references('id')->on('test_series_categories')->onDelete('set null');
        });
    }
}
