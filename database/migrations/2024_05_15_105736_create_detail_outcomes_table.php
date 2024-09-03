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
        Schema::create('detail_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outcomes_id')->constrained()->references('id')->on('outcomes')->cascadeOnDelete();
            $table->foreignId('account_id')->constrained()->references('id')->on('accounts')->cascadeOnDelete();
            $table->foreignId('stock_entry_id')->constrained()->references('id')->on('stock_entries')->cascadeOnDelete();
            $table->string('note');
            $table->string('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_outcomes');
    }
};
