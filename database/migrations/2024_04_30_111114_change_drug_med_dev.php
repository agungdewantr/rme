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
            $table->string('type')->nullable();
            $table->date('expired_date')->nullable();
            $table->foreignId('id_category')->nullable()->constrained()->references('id')->on('category_drug_med_devs')->cascadeOnDelete();
            $table->renameColumn('category','jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drug_med_devs', function (Blueprint $table) {
            //
        });
    }
};
