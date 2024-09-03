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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_filter')->nullable()->constrained()->references('id')->on('branches')->nullOnDelete();
            $table->foreignId('doctor_filter')->nullable()->constrained()->references('id')->on('health_workers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('branch_filter');
            $table->dropColumn('doctor_filter');
        });
    }
};
