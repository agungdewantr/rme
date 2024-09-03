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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('patient_number');
            $table->char('nik', 16)->unique();
            $table->string('name');
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_number');
            $table->boolean('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('photo_profile')->nullable();
            $table->foreignId('job_id')->nullable()->constrained()->references('id')->on('jobs')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
