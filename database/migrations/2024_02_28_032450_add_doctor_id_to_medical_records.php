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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn('health_worker_id');
        });
        Schema::table('medical_records', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('nurse_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn('doctor_id');
            $table->dropColumn('nurse_id');
        });
        Schema::table('medical_records', function (Blueprint $table) {
            $table->foreignId('health_worker_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
