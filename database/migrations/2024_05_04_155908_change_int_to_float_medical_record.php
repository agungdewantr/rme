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
            $table->float('height',8,2)->nullable()->change();
            $table->float('weight',8,2)->nullable()->change();
            $table->float('body_temperature',8,2)->nullable()->change();
            $table->float('sistole',8,2)->nullable()->change();
            $table->float('diastole',8,2)->nullable()->change();
            $table->float('pulse',8,2)->nullable()->change();
            $table->float('respiratory_frequency',8,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            //
        });
    }
};
