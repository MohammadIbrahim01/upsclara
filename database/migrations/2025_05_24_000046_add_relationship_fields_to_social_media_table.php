<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSocialMediaTable extends Migration
{
    public function up()
    {
        Schema::table('social_media', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_10585013')->references('id')->on('companies')->onDelete('cascade');
        });
    }
}
