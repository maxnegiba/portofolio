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
        Schema::table('blog_posts', function (Blueprint $table) {
            // Modifică coloana slug să fie de tip json
            // PostgreSQL necesită recrearea coloanei pentru schimbarea tipului
            $table->dropColumn('slug'); // Sau salvează datele dacă ai deja slug-uri
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('slug')->index(); // Adaugă coloana slug ca json
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            // Revenim la varianta anterioară dacă e cazul
            $table->string('slug')->unique();
            // Sau recreăm coloana veche cu tipul anterior dacă era alta
        });
    }
};