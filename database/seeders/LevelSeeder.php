<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = ['ketua', 'wakil_ketua', 'panitera', 'sekretaris', 'kabag_perencanaan','kabag_keuangan','kasubag_renprog','kasubag_kepegawaian','kasubag_tu_rt','kasubag_keuangan','panmud_perdata', 'panmud_pidana', 'panmud_hukum', 'panmud_tipikor', 'admin_renprog', 'admin_kepegawaian','admin_tu_rt', 'admin_keuangan', 'user','super_admin'];
        foreach ($levels as $level) {
            DB::table('levels')->insert([
                'nama_level' => $level,
            ]);
        }
    }
}
