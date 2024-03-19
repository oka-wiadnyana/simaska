<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['nama_jabatan' => 'Ketua'],
            ['nama_jabatan' => 'Wakil Ketua'],
            ['nama_jabatan' => 'Panitera'],
            ['nama_jabatan' => 'Sekretaris'],
            ['nama_jabatan' => 'Hakim'],
            ['nama_jabatan' => 'Kabag Perencanaan dan Kepegawaian'],
            ['nama_jabatan' => 'Kabag Perencanaan dan Kepegawaian'],
            ['nama_jabatan' => 'Kasubag Rencana Program dan Anggaran'],
            ['nama_jabatan' => 'Kasubag Kepegawaian dan Teknologi Informasi'],
            ['nama_jabatan' => 'Kasubag Tata Usaha dan Rumah Tangga'],
            ['nama_jabatan' => 'Kasubag Keuangan dan Pelaporan'],
            ['nama_jabatan' => 'Panitera Muda Pidana'],
            ['nama_jabatan' => 'Panitera Muda Perdata'],
            ['nama_jabatan' => 'Panitera Muda Hukum'],
            ['nama_jabatan' => 'Panitera Muda Tipikor'],
            ['nama_jabatan' => 'Staf Subag Rencana Program dan Anggaran'],
            ['nama_jabatan' => 'Staf Subag Kepegawaian dan Teknologi Informasi'],
            ['nama_jabatan' => 'Staf Subag Tata Usaha dan Rumah Tangga'],
            ['nama_jabatan' => 'Staf Subag Keuangan dan Pelaporan'],
            ['nama_jabatan' => 'Staf Kepaniteraan Muda Pidana'],
            ['nama_jabatan' => 'Staf Kepaniteraan Muda Perdata'],
            ['nama_jabatan' => 'Staf Kepaniteraan Muda Hukum'],
            ['nama_jabatan' => 'Staf Kepaniteraan Muda Tipikor'],
            ['nama_jabatan' => 'Sopir','is_ppnpn'=>'Y'],
            ['nama_jabatan' => 'Pramubakti','is_ppnpn'=>'Y'],
            ['nama_jabatan' => 'Petugas Keamanan','is_ppnpn'=>'Y'],
            ['nama_jabatan' => 'Super Admin'],
            

         
        ];
        foreach ($positions as $position) {
            $dataInsert=isset($position['is_ppnpn'])?[
                'nama_jabatan' => $position['nama_jabatan'],
                'is_ppnpn' => $position['is_ppnpn'],
               

            ]:
            [
                'nama_jabatan' => $position['nama_jabatan'],
               
               

            ];
            DB::table('positions')->insert($dataInsert);
        }
    }
}
