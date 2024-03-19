<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['nama_unit' => 'Ketua'],
            ['nama_unit' => 'Wakil Ketua'],
            ['nama_unit' => 'Panitera'],
            ['nama_unit' => 'Sekretaris'],
            ['nama_unit' => 'Hakim'],
            ['nama_unit' => 'Bagian Perencanaan dan Kepegawaian'],
            ['nama_unit' => 'Bagian Umum dan Keuangan'],
            ['nama_unit' => 'SubBagian Rencana Program dan Anggaran'],
            ['nama_unit' => 'SubBagian Kepegawaian dan Teknologi Informasi'],
            ['nama_unit' => 'SubBagian Tata Usaha dan Rumah Tangga'],
            ['nama_unit' => 'SubBagian Keuangan dan Pelaporan'],
            ['nama_unit' => 'Kepaniteraan Muda Pidana'],
            ['nama_unit' => 'Kepaniteraan Muda Perdata'],
            ['nama_unit' => 'Kepaniteraan Muda Hukum'],
            ['nama_unit' => 'Kepaniteraan Muda Tipikor'],
            ['nama_unit' => 'Super Admin'],

         
        ];
        foreach ($units as $unit) {
            DB::table('units')->insert([
                'nama_unit' => $unit['nama_unit'],
              

            ]);
        }
    }
}
