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
        Schema::create('stock_entry_has_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_entry_id')->constrained()->references('id')->on('stock_entries')->cascadeOnDelete();
            $table->foreignId('batch_id')->constrained()->references('id')->on('batches')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entry_has_batches');
    }
};
