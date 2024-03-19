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
        Schema::create('orderfullfills', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->json('orderfullfills_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('sign')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderfullfills');
    }
};
