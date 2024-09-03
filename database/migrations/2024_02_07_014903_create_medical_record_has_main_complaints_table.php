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
        Schema::create('medical_record_has_main_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->references('id')->on('medical_records')->cascadeOnDelete();
            $table->foreignId('main_complaint_id')->constrained()->references('id')->on('main_complaints')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record_has_main_complaints');
    }
};
