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
        Schema::create('operational_hours', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable();
            $table->foreignId('branch_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->string('day')->nullable();
            $table->string('shift')->nullable();
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operational_hours');
    }
};
