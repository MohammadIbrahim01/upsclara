<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmailsTable extends Migration
{
    public function up()
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_10584982')->references('id')->on('companies')->onDelete('cascade');
        });
    }
}
