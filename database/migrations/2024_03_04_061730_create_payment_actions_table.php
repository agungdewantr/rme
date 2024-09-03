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
        Schema::create('payment_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreignId('action_id')->constrained()->references('id')->on('actions')->cascadeOnDelete();
            $table->string('discount')->default(0);
            $table->string('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_actions');
    }
};
