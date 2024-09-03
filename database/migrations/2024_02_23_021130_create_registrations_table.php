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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('queue_number')->nullable();
            $table->date('date');
            $table->string('type');
            $table->time('estimated_arrival');
            $table->text('complaints');
            $table->foreignId('branch_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
