<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('publikasi_terindeks', function (Blueprint $table) {
            $table->id();
            
            // Informasi Dasar Publikasi
            $table->string('judul');
            $table->text('abstrak')->nullable();
            $table->string('penulis');
            // $table->text('daftar_penulis')->nullable(); // Untuk penulis tambahan (JSON)
            
            // Informasi Jurnal
            $table->string('nama_jurnal');
            $table->string('issn')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->integer('tahun_terbit');
            $table->string('halaman')->nullable(); // Contoh: "123-135"
            
            // Indeksasi dan Metrik
            $table->string('indeksasi'); // SCOPUS, WOS, SINTA, dll
            $table->integer('quartile')->nullable(); // Q1, Q2, Q3, Q4
            $table->string('impact_factor')->nullable();
            $table->string('doi')->nullable();
            
            // Link dan File
            $table->string('url_jurnal')->nullable();
            $table->string('file_pdf')->nullable(); // Untuk upload PDF
            $table->string('cover_image')->nullable(); // Gambar cover jurnal
            
            // Kategori dan Bidang
            $table->string('bidang_ilmu')->nullable(); // Computer Science, Engineering, dll
            $table->string('kategori_publikasi')->nullable(); // Article, Conference Paper, Review
            
            // Status dan Metadata
            $table->boolean('is_active')->default(true);
            $table->integer('jumlah_dikutip')->default(0);
            $table->date('tanggal_publish')->nullable();
            
            // Relasi dengan user/dosen (jika diperlukan)
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            // $table->foreignId('dosen_id')->nullable()->constrained('dosens')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publikasi_keyword');
        Schema::dropIfExists('keywords');
        Schema::dropIfExists('publikasi_terindeks');
    }
};