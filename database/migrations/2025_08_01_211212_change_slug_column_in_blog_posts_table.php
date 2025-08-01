<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificăm dacă coloana slug de tip string există
        if (Schema::hasColumn('blog_posts', 'slug') && !Schema::getColumnType('blog_posts', 'slug') === 'json') {
            // Adăugăm o coloană temporară pentru a salva valorile vechi
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->text('slug_old')->nullable();
            });

            // Copiem valorile din slug în slug_old
            DB::table('blog_posts')->update(['slug_old' => DB::raw('"slug"')]);

            // Ștergem vechea coloană slug
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }

        // Adăugăm coloana slug ca json
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('slug')->nullable(); // Inițial o lăsăm nullable
        });

        // Convertim valorile vechi în format JSON (presupunând limba implicită 'en')
        $defaultLocale = config('app.locale', 'en');
        DB::table('blog_posts')->whereNotNull('slug_old')->update([
            'slug' => DB::raw("jsonb_build_object('{$defaultLocale}', \"slug_old\")")
        ]);

        // Ștergem coloana temporară
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug_old');
        });

        // Facem coloana slug NOT NULL (opțional, dacă vrei să forțezi valori)
        // Schema::table('blog_posts', function (Blueprint $table) {
        //     $table->json('slug')->nullable(false)->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        // Revenim la varianta anterioară dacă e cazul
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('slug')->unique();
        });
    }
};