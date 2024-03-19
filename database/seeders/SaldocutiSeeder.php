<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaldocutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nips = DB::table('employees')->select('nip')->get();

        foreach ($nips as $nip) {
            DB::table('saldo_cuti')->insert([
                'nip' => $nip->nip,
                'tahun' => '2022',
                'saldo_cuti' => 12,

            ]);
        }
    }
}
