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
        Schema::table('laborates', function (Blueprint $table) {
            $table->dropColumn('medical_record_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laborates', function (Blueprint $table) {
            $table->foreignId('medical_record_id')->nullable()->constrained()->references('id')->on('medical_records')->cascadeOnDelete();
        });
    }
};
