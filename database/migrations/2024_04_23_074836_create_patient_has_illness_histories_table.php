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
        Schema::create('patient_has_illness_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->references('id')->on('patients')->cascadeOnDelete();
            $table->foreignId('illness_history_id')->constrained()->references('id')->on('illness_histories')->cascadeOnDelete();
            $table->string('therapy');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_has_illness_histories');
    }
};
