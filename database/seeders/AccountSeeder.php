<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            'Beban Peralatan Medis',
            'Beban Peralatan Kantor',
            'Iuran ',
            'Beban Listrik',
            'Beban Air',
            'Beban Wifi',
            'Beban gaji dr. Christina',
            'Beban gaji dr. Almira',
            'Beban gaji dr. Amilah',
            'Beban gaji dr. Priza',
            'Beban gaji dr. Prima',
            'Beban gaji karyawan',
            'Beban THR',
            'Takjil dan lain-lain',
            'Beban zakat',
            'Beban sewa bangunan',
            'Beban penyusutan mesin',
            'Penjualan obat'
        ];

        foreach ($accounts as $account) {
            \App\Models\Account::create([
                'name' => $account
            ]);
        }
    }
}
