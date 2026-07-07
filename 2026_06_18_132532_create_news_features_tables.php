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
    // Tabel Kategori Favorit pilihan User
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('category_name'); // Contoh: 'technology', 'sports'
        $table->timestamps();
    });

    // Tabel Simpan Berita (Bookmark)
    Schema::create('bookmarks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('news_title');
        $table->text('news_url'); // Link asli berita
        $table->text('image_url')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_features_tables');
    }
};
