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
        Schema::create('drug_med_dev_price_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('old_price');
            $table->unsignedInteger('new_price');
            $table->foreignId('drug_med_dev_id')->constrained()->references('id')->on('drug_med_devs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_med_dev_price_histories');
    }
};
