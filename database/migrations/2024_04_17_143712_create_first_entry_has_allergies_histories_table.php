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
        Schema::create('first_entry_has_allergies_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_entry_id')->constrained()->references('id')->on('first_entries')->cascadeOnDelete();
            $table->foreignId('allergy_history_id')->constrained()->references('id')->on('allergy_histories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_entry_has_allergies_histories');
    }
};
