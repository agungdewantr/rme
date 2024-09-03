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
        Schema::create('tmp_data', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('value')->nullable();
            $table->string('location');
            $table->integer('user_id');
            $table->string('field_type');
            $table->bigInteger('temp_id');
            $table->string('field_group');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_data');
    }
};
