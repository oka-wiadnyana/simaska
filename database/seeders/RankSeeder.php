<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranks = [
            ['pangkat' => 'Pengatur', 'golongan' => 'II/c'],
            ['pangkat' => 'Pengatur Tk.I', 'golongan' => 'II/d'],
            ['pangkat' => 'Penata Muda', 'golongan' => 'III/a'],
            ['pangkat' => 'Penata Muda Tk.I', 'golongan' => 'III/b'],
            ['pangkat' => 'Penata', 'golongan' => 'III/c'],
            ['pangkat' => 'Penata Tk.I', 'golongan' => 'III/d'],
            ['pangkat' => 'Pembina', 'golongan' => 'IV/a'],
            ['pangkat' => 'Pembina Tk.I', 'golongan' => 'IV/b'],
            ['pangkat' => 'Pembina Utama Muda', 'golongan' => 'IV/c'],
            ['pangkat' => 'Pembina Utama Madya', 'golongan' => 'IV/d'],
            ['pangkat' => 'Pembina Utama', 'golongan' => 'IV/e'],
            ['pangkat' => 'Super Admin', 'golongan' => 'Super Admin'],
        ];
        foreach ($ranks as $rank) {
            DB::table('ranks')->insert([
                'pangkat' => $rank['pangkat'],
                'golongan' => $rank['golongan'],

            ]);
        }
    }
}
