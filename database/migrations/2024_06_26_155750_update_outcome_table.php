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
        Schema::table('outcomes', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->integer('nominal')->nullable();
            $table->foreignId('account_id')->nullable()->constrained()->references('id')->on('accounts')->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->references('id')->on('suppliers')->cascadeOnDelete();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outcomes', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropColumn('account_id');
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');
        });
    }
};
