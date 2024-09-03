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
        Schema::create('stock_transfer_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transfer_id')->constrained()->references('id')->on('stock_transfers')->cascadeOnDelete();
            $table->foreignId('batch_id')->constrained()->references('id')->on('batches')->cascadeOnDelete();
            $table->integer('qty_used');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_batches');
    }
};
