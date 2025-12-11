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
        Schema::create('komentars', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel artikels
            $table->foreignId('artikel_id')
                  ->constrained('artikels')
                  ->onDelete('cascade'); // Hapus komentar saat artikel dihapus
            
            // Foreign key ke tabel users (opsional, untuk user yang login)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); // Set null saat user dihapus
            
            // Kolom untuk tamu (guest)
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            
            // Kolom utama
            $table->text('konten');
            
            // Status moderasi
            $table->boolean('is_approved')->default(false);
            
            // Kolom untuk reply (opsional)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('komentars')
                  ->onDelete('cascade');
            
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['artikel_id', 'is_approved']);
            $table->index(['artikel_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};