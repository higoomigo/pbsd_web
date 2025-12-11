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
        Schema::create('penelitis', function (Blueprint $table) {
            $table->id();
            
            // Identitas Dasar
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('foto_path')->nullable();
            
            // Informasi Profesional
            $table->json('bidang_keahlian')->nullable(); // ['Artificial Intelligence', 'Data Science', 'NLP']
            $table->string('posisi')->default('Peneliti'); // Peneliti Utama, Asisten Peneliti, Research Fellow
            $table->string('jabatan')->nullable(); // Kepala Lab, Koordinator Riset, dll
            $table->text('riwayat_pendidikan')->nullable(); // JSON atau text formatted
            
            // Kontak & Informasi
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable(); // {linkedin: '', google_scholar: '', researchgate: ''}
            
            // Konten Profil
            $table->text('deskripsi_singkat')->nullable(); // untuk card/tampilan list
            $table->text('biografi')->nullable(); // profil lengkap
            $table->json('publikasi_terpilih')->nullable(); // judul publikasi penting
            $table->json('penelitian_unggulan')->nullable(); // judul penelitian unggulan
            $table->text('pencapaian')->nullable(); // awards, grants, achievements
            
            // Status & Metadata
            $table->enum('status', ['Aktif', 'Pensiun', 'Alumni', 'Mitra'])->default('Aktif');
            $table->enum('tipe', ['Internal', 'Eksternal', 'Kolaborator'])->default('Internal');
            $table->integer('urutan')->default(0);
            $table->boolean('tampil_beranda')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('tipe');
            $table->index('is_published');
            $table->index('urutan');
            $table->index('tampil_beranda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};