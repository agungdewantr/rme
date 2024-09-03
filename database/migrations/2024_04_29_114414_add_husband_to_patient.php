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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('husbands_name')->nullable();
            $table->string('husbands_nik')->nullable();
            $table->string('husbands_address')->nullable();
            $table->string('husbands_citizenship')->nullable();
            $table->string('husbands_job')->nullable();
            $table->date('husbands_birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
};
