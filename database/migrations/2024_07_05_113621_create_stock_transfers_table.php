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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('stock_transfer_number');
            $table->date('date');
            $table->date('status');
            $table->text('description')->nullable();
            $table->foreignId('form_branch_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->foreignId('to_branch_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained()->references('id')->on('payment_methods')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
