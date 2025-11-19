<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();

            $table->string('judul', 255);
            $table->string('slug', 255)->unique();

            // kategori: Kegiatan, Pengumuman, Rilis, Opini, Publikasi
            $table->string('kategori', 50)->index();

            // tag disimpan sebagai string "a, b, c" (nullable)
            $table->string('tag', 500)->nullable();

            $table->text('ringkasan')->nullable();
            $table->longText('konten');

            // path file di storage public (nullable)
            $table->string('thumbnail_path', 512)->nullable();

            $table->timestamp('published_at')->nullable()->index();

            // penulis (opsional)
            $table->foreignId('author_id')->nullable()
                  ->constrained('users')->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();

            // (opsional) fulltext untuk pencarian MySQL 5.7+/8.0+
            // $table->fullText(['judul', 'ringkasan', 'konten']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
