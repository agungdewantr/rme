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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('transaction_number');
            $table->date('date');
            $table->string('payment_method');
            $table->string('bank')->nullable();
            $table->foreignId('medical_record_id')->constrained()->references('id')->on('medical_records')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
