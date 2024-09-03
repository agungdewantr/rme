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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('medical_record_number');
            $table->date('date');
            //subjectif-anamnesa
            $table->integer('gravida')->nullable();
            $table->integer('para')->nullable();
            $table->integer('hidup')->nullable();
            $table->integer('birth_description')->nullable();
            $table->integer('abbortion')->nullable();
            $table->date('hpht')->nullable();
            $table->date('interpretation_childbirth')->nullable();
            $table->text('other_history')->nullable();
            $table->foreignId('health_worker_id')->nullable()->constrained()->references('id')->on('health_workers')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            //objektif-rekam medis
            $table->string('patient_awareness')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('body_temperature')->nullable();
            $table->integer('sistole')->nullable();
            $table->integer('diastole')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('respiratory_frequency')->nullable();
            $table->text('description')->nullable();
            //assessment
            $table->text('diagnose')->nullable();
            $table->string('ga')->nullable();
            $table->string('gs')->nullable();
            $table->string('crl')->nullable();
            $table->string('hc')->nullable();
            $table->string('ac')->nullable();
            $table->string('fhr')->nullable();
            $table->string('fw')->nullable();
            $table->string('bpd')->nullable();
            $table->string('edd')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('random_blood_sugar')->nullable();
            $table->string('hemoglobin')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('hiv')->nullable();
            $table->string('syphilis')->nullable();
            $table->string('urine_reduction')->nullable();
            $table->string('urine_protein')->nullable();
            $table->string('ph')->nullable();
            //plan
            $table->date('next_control')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
