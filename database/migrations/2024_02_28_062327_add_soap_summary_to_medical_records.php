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
            $table->text('subjective_summary')->nullable();
            $table->text('objective_summary')->nullable();
            $table->text('assessment_summary')->nullable();
            $table->text('plan_summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn('subjective_summary');
            $table->dropColumn('objective_summary');
            $table->dropColumn('assessment_summary');
            $table->dropColumn('plan_summary');
        });
    }
};
