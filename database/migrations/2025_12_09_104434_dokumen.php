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
        // database/migrations/xxxx_create_dokumen_table.php
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koleksi_dokumen_id')->nullable()->constrained('koleksi_dokumen')->onDelete('set null');
            $table->string('kode')->unique();
            $table->string('judul');
            $table->string('slug')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->string('kategori')->nullable();
            $table->string('sub_kategori')->nullable();
            $table->string('format_asli')->nullable();
            $table->string('format_digital')->nullable();
            $table->integer('ukuran_file')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('sumber')->nullable();
            $table->string('lembaga')->nullable();
            $table->string('lokasi_fisik')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('bahasa')->nullable();
            $table->integer('halaman')->nullable();
            $table->integer('prioritas')->default(0);
            $table->text('catatan')->nullable();
            
            // File paths
            $table->string('file_digital_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('preview_path')->nullable();
            
            // Google Drive
            $table->string('google_drive_id')->nullable();
            $table->text('google_drive_link')->nullable();
            $table->text('google_drive_thumbnail')->nullable();
            
            // Publication
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_utama')->default(false);
            $table->integer('urutan')->default(0);
            
            // Stats
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('koleksi_dokumen_id');
            $table->index('kategori');
            $table->index('is_published');
            $table->index('is_utama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
