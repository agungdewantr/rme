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
        Schema::table('medical_record_has_drug_med_devs', function (Blueprint $table) {
            $table->integer('total');
            $table->string('rule');
        });
        Schema::table('medical_record_has_actions', function (Blueprint $table) {
            $table->integer('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_record_has_drug_med_devs', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('rule');
        });
        Schema::table('medical_record_has_actions', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
