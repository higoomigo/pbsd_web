<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->nullable();     // mis: Opini/Esai/Analisis/Publikasi
            $table->string('penulis')->nullable();      // penulis manual (jamak nama)
            $table->foreignId('author_id')->nullable()  // relasi ke users (opsional)
                  ->constrained('users')->nullOnDelete();
            $table->string('tag')->nullable();          // "a, b, c"
            $table->string('thumbnail_path')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['published_at', 'kategori']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('artikels');
    }
};
