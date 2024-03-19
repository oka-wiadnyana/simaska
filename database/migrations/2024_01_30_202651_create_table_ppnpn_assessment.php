<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_ppnpn_assessment', function (Blueprint $table) {
            $table->id();
            $table->integer('ppnpn_id');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('integritas');
            $table->integer('kedisiplinan');
            $table->integer('kerjasama');
            $table->integer('komunikasi');
            $table->integer('pelayanan');
            $table->integer('jumlah_kehadiran')->nullable();
            $table->integer('jumlah_hari_kerja')->nullable();
            $table->integer('penilai_id')->nullable();
            $table->text('evaluasi')->nullable();
            $table->string('is_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_ppnpn_assessment');
    }
};
