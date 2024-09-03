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
            $table->unsignedInteger('price')->default(0);
        });
        Schema::table('payment_drugs', function (Blueprint $table) {
            $table->unsignedInteger('price')->default(0);
        });
        Schema::table('payment_laborates', function (Blueprint $table) {
            $table->unsignedInteger('price')->default(0);
        });
        Schema::table('transaction_payment_methods', function (Blueprint $table) {
            $table->integer('change')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_actions', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('payment_drugs', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('payment_laborates', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('transaction_payment_methods', function (Blueprint $table) {
            $table->dropColumn('change');
        });
    }
};
