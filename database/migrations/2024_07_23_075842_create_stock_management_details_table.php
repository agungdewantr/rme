<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_management_details', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_uom');
            $table->integer('item_qty');
            $table->integer('item_price');
            $table->date('item_expired_date');
            $table->foreignId('stock_entry_id')->constrained()->references('id')->on('stock_entries')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_management_details');
    }
};
