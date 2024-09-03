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
        Schema::table('payment_actions', function (Blueprint $table) {
            $table->boolean('isPromo')->default(false)->nullable();
        });
        Schema::table('payment_drugs', function (Blueprint $table) {
            $table->boolean('isPromo')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_actions', function (Blueprint $table) {
            $table->dropColumn('isPromo');
        });
        Schema::table('payment_drugs', function (Blueprint $table) {
            $table->dropColumn('isPromo');
        });
    }
};
