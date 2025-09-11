<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frontend_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->string('profile_picture')->nullable(); // profile pic path
            $table->timestamp('email_verified_at')->nullable(); // email verify
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive
            $table->string('role')->default('user'); // user, admin, premium etc.
            $table->rememberToken(); // remember me token
            $table->timestamps(); // created_at + updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontend_users');
    }
};
