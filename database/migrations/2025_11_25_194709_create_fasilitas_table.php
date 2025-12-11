<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas');
            $table->text('deskripsi');
            $table->string('gambar_path');
            $table->string('alt_text')->nullable();
            $table->boolean('tampil_beranda')->default(false); // untuk menampilkan di beranda
            $table->integer('urutan_tampil')->default(0); // untuk mengatur urutan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fasilitas');
    }
};