<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetQtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = Batch::all();
        $batches->each(function ($batch) {
            $batch->update(['qty_ori' => $batch->qty]);
        });
    }
}
