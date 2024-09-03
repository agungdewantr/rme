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
        Schema::table('first_entries', function (Blueprint $table) {
            $table->string('patient_awareness')->nullable();
            $table->string('neck')->nullable();
            $table->string('head')->nullable();
            $table->string('chest')->nullable();
            $table->string('eye')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('heart')->nullable();
            $table->string('extremities')->nullable();
            $table->string('lungs')->nullable();
            $table->string('skin')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('first_entries', function (Blueprint $table) {
            //
        });
    }
};
