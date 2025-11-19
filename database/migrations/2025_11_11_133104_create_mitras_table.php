<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['Pemerintah','Perguruan Tinggi','Lembaga Riset','Komunitas','Industri']);
            $table->text('deskripsi')->nullable();
            $table->string('website')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('telepon')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->date('mulai')->nullable();
            $table->date('berakhir')->nullable();
            $table->enum('status', ['Aktif','Tidak Aktif'])->default('Aktif');
            $table->integer('urutan')->default(0);
            $table->boolean('tampil_beranda')->default(false);
            $table->string('logo_path')->nullable();
            $table->string('dokumen_mou_path')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
