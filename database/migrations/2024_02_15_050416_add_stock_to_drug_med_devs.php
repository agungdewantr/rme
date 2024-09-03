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
        Schema::table('drug_med_devs', function (Blueprint $table) {
            $table->integer('stock');
            $table->uuid()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drug_med_devs', function (Blueprint $table) {
            $table->dropColumn('stock');
            $table->dropColumn('uuid');
        });
    }
};
