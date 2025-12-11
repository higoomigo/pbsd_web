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
        Schema::create('galeri_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeri_album_id')->constrained('galeri_albums')->onDelete('cascade');
            $table->enum('tipe', ['foto', 'video', 'youtube'])->default('foto');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->string('file_path', 500)->nullable(); // untuk upload gambar/video lokal
            $table->string('thumbnail_path', 500)->nullable(); // thumbnail khusus (opsional, untuk video)
            $table->string('youtube_url', 500)->nullable(); // untuk embed dari YouTube
            $table->timestamp('taken_at')->nullable(); // tanggal pengambilan (opsional)
            $table->integer('urutan')->default(0);
            $table->boolean('is_utama')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('galeri_album_id');
            $table->index('tipe');
            $table->index('urutan');
            $table->index('is_utama');
            $table->index('taken_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri_media');
    }
};