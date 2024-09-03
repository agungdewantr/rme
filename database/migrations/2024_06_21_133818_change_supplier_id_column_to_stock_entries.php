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
        Schema::table('stock_entries', function (Blueprint $table) {
            if (DB::getDoctrineSchemaManager()->listTableDetails('stock_entries')->hasForeignKey('stock_entries_supplier_id_foreign')) {
                $table->dropForeign('stock_entries_supplier_id_foreign');
            }
            // Re-add the foreign key with the new reference
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_entries', function (Blueprint $table) {
            //
        });
    }
};
