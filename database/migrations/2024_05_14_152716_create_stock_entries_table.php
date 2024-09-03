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
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('stock_entry_number');
            $table->date('date');
            $table->string('purpose');
            $table->string('status');
            $table->foreignId('receiver_id')->constrained()->references('id')->on('health_workers')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->references('id')->on('branches')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
