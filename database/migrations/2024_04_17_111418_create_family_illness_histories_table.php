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
        Schema::create('family_illness_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->references('id')->on('patients')->cascadeOnDelete();
            $table->string('name');
            $table->string('relationship');
            $table->string('disease_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_illness_histories');
    }
};
