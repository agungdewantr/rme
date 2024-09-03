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
        Schema::create('drug_med_devs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->integer('min_stock');
            $table->string('uom');
            $table->string('purchase_price');
            $table->string('selling_price');
            $table->boolean('is_can_minus')->default(false);
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_med_devs');
    }
};
