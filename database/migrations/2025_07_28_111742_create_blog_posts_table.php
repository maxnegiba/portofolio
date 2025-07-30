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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            // === Modificări pentru traduceri ===
            // Câmpurile care vor fi traduse trebuie să fie de tip JSON
            $table->json('title');
            // Dacă vrei slug tradus, schimbă linia de mai jos în: $table->json('slug')->unique();
            // Pentru simplitate, îl păstrăm string (unic global)
            $table->string('slug')->unique(); 
            $table->json('excerpt')->nullable();
            $table->json('content');
            // ================================

            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            // === Meta Keywords rămâne JSON (poate fi diferit per limbă sau nu) ===
            $table->json('meta_keywords')->nullable(); 
            // ====================================================================

            // === Meta Description tradus ===
            $table->json('meta_description')->nullable();
            // =============================

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['is_published', 'published_at']);
            // Indexul pentru slug rămâne, chiar dacă `slug` e tradus, pentru căutări rapide
            // Dacă slug e JSON, indexarea devine mai complexă și trebuie gestionată altfel.
            $table->index('slug'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};