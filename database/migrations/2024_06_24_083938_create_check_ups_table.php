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
        Schema::create('check_ups', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->boolean('is_active');
            $table->foreignId('poli_id')->constrained()->references('id')->on('polis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ups');
    }
};
