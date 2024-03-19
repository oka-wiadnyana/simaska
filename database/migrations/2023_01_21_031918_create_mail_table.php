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
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_index')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->text('perihal')->nullable();
            $table->string('tujuan', 500)->nullable();
            $table->integer('employee_id')->nullable();
            $table->text('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mails');
    }
};
