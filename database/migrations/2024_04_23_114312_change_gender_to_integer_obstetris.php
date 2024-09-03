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
        DB::statement('ALTER TABLE obstetris ALTER COLUMN
                  gender TYPE integer USING (gender)::integer');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obstetris', function (Blueprint $table) {
            $table->boolean('gender')->change();
        });
    }
};
