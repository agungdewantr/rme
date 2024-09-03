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
        Schema::create('payment_laborates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreignId('laborate_id')->constrained()->references('id')->on('laborates')->cascadeOnDelete();
            $table->integer('qty')->default(1);
            $table->integer('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_laborates');
    }
};
