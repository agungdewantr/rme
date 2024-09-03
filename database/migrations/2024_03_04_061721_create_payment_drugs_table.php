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
        Schema::create('payment_drugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreignId('drug_med_dev_id')->constrained()->references('id')->on('drug_med_devs')->cascadeOnDelete();
            $table->string('discount')->default(0);
            $table->string('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_drugs');
    }
};
