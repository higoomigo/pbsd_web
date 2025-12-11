<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kebijakans', function (Blueprint $table) {
            $table->id();

            // Identitas dokumen
            $table->string('judul');
            $table->string('kategori', 100)->default('Kebijakan');
            $table->string('nomor_dokumen')->nullable();
            $table->string('versi', 50)->nullable();

            // Konten
            $table->text('ringkasan')->nullable();
            $table->longText('isi')->nullable();

            // Otoritas & penanggung jawab
            $table->string('otoritas_pengesah')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('unit_terkait')->nullable();

            // Tanggal & siklus
            $table->date('tanggal_berlaku')->nullable();
            $table->date('tanggal_tinjau_berikutnya')->nullable();
            $table->string('siklus_tinjau', 50)->nullable(); // Tahunan / Semester / dst.

            // Dokumen & lampiran
            $table->string('dokumen_path')->nullable();     // path PDF utama
            $table->json('lampiran_paths')->nullable();     // array path lampiran

            // Status & tags
            $table->enum('status', ['Draft', 'Publik'])->default('Draft');
            $table->string('tags')->nullable();             // string "a, b, c"

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebijakans');
    }
};
