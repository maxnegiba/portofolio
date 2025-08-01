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

            // Câmpuri traduse - tip JSON
            $table->json('title');
            $table->json('slug');
            $table->json('excerpt')->nullable();
            $table->json('content');
            
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // Câmpuri meta
            $table->json('meta_keywords')->nullable();
            $table->json('meta_description')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['is_published', 'published_at']);
            // Eliminăm indexul pe coloana JSON - cauzează eroare în PostgreSQL
            // $table->index('slug');
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