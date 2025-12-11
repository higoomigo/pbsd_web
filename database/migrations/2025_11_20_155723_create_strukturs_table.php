<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('strukturs', function (Blueprint $table) {
            $table->id();
            $table->longText('deskripsi')->nullable();     // teks penjelasan
            $table->string('gambar_path')->nullable();     // path file di storage/public
            $table->string('alt_text', 255)->nullable();   // alt text untuk aksesibilitas/SEO
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strukturs');
    }
};
