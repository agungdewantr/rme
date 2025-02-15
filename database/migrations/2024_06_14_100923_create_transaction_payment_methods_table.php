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
        Schema::create('transaction_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained()->references('id')->on('payment_methods')->cascadeOnDelete();
            $table->unsignedInteger('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_payment_methods');
    }
};
