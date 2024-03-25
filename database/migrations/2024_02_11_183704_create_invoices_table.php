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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->string('description');
            $table->string('year_invoiced')->nullable();
            $table->string('month_invoiced')->nullable();
            $table->string('concept');
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_id');

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('subscription_id')
                ->references('id')->on('subscriptions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
