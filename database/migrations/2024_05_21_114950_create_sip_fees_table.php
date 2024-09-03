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
        Schema::create('sip_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('action_id')->constrained()->references('id')->on('actions')->cascadeOnDelete();
            $table->string('sip_fee');
            $table->string('non_sip_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sip_fees');
    }
};
