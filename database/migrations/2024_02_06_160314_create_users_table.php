<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document_type');
            $table->string('document_number')->unique();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('old_code')->unique();
            $table->string('paid_subscription');
            $table->string('address');
            $table->string('city');
            $table->string('municipality');
            $table->string('password');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
