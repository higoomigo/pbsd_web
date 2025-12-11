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
        Schema::create('galeri_albums', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('deskripsi_singkat', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kategori', 100)->nullable();
            $table->integer('tahun')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->string('cover_path', 500)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('tampil_beranda')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('is_published');
            $table->index('published_at');
            $table->index('tampil_beranda');
            $table->index('urutan');
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri_albums');
    }
};