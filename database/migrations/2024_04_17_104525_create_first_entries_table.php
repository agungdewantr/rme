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
        Schema::create('first_entries', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->dateTime('time_stamp');
            $table->foreignId('doctor_id')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('nurse_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->date('hpht')->nullable();
            $table->date('edd')->nullable();
            $table->text('main_complaint');
            $table->text('specific_attention')->nullable();
            $table->foreignId('patient_id')->constrained()->references('id')->on('patients')->cascadeOnDelete();
            $table->foreignId('registration_id')->nullable()->constrained()->references('id')->on('registrations')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_entries');
    }
};
