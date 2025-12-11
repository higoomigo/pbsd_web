<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            
            // Informasi Dasar Seminar
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->text('ringkasan')->nullable();
            
            // Informasi Waktu & Tempat
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->string('tempat');
            $table->string('alamat_lengkap')->nullable();
            $table->string('link_virtual')->nullable(); // Untuk seminar online/hybrid
            
            // Informasi Pembicara
            $table->string('pembicara');
            $table->string('institusi_pembicara')->nullable();
            $table->text('bio_pembicara')->nullable();
            $table->string('foto_pembicara')->nullable();
            
            // Kategori & Status
            $table->enum('tipe', ['nasional', 'internasional', 'workshop', 'webinar', 'lainnya']);
            $table->enum('format', ['offline', 'online', 'hybrid']);
            $table->string('topik')->nullable();
            $table->string('bidang_ilmu')->nullable();
            
            // Informasi Pendaftaran
            $table->boolean('gratis')->default(true);
            $table->decimal('biaya', 10, 2)->nullable();
            $table->string('link_pendaftaran')->nullable();
            $table->date('batas_pendaftaran')->nullable();
            $table->integer('kuota_peserta')->nullable();
            $table->integer('peserta_terdaftar')->default(0);
            
            // Konten & Media
            $table->string('poster')->nullable();
            $table->string('dokumen_materi')->nullable();
            $table->string('video_rekaman')->nullable();
            $table->text('galeri_foto')->nullable(); // JSON array of images
            
            // SEO & Metadata
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status & Publikasi
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            
            // Relasi
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminars');
    }
};