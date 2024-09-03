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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('document_reference');
            $table->integer('current_qty');
            $table->integer('in');
            $table->integer('out');
            $table->integer('qty');
            $table->foreignId('item_id')->constrained()->references('id')->on('drug_med_devs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
