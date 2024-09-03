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
        Schema::table('first_entries', function (Blueprint $table) {
            $table->date('date_lab')->nullable();
            $table->float('height',8,2)->nullable();
            $table->float('weight',8,2)->nullable();
            $table->float('body_temperature',8,2)->nullable();
            $table->float('sistole',8,2)->nullable();
            $table->float('diastole',8,2)->nullable();
            $table->float('pulse',8,2)->nullable();
            $table->float('respiratory_frequency',8,2)->nullable();
            $table->text('description_physical')->nullable();

            $table->string('blood_type')->nullable();
            $table->string('random_blood_sugar')->nullable();
            $table->string('hemoglobin')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('hiv')->nullable();
            $table->string('syphilis')->nullable();
            $table->string('urine_reduction')->nullable();
            $table->string('urine_protein')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('first_entries', function (Blueprint $table) {
            //
        });
    }
};
