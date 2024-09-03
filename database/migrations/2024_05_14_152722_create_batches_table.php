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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number');
            $table->date('expired_date');
            $table->string('new_price');
            $table->integer('qty');
            $table->foreignId('item_id')->constrained()->references('id')->on('drug_med_devs')->cascadeOnDelete();
            $table->foreignId('stock_entry_id')->constrained()->references('id')->on('stock_entries')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
