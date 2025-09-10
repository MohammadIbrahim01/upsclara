<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBlogCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->foreign('blog_category_id', 'blog_category_fk_10584808')->references('id')->on('blog_categories')->onDelete('set null');
        });
    }
}
