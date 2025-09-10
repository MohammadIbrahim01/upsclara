<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCareerApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('career_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('job_opening_id')->nullable();
            $table->foreign('job_opening_id', 'job_opening_fk_10584900')->references('id')->on('job_openings')->onDelete('set null');
        });
    }
}
