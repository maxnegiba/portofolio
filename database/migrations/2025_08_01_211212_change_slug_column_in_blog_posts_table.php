<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private string $defaultLocale;

    public function __construct()
    {
        // Obține limba implicită din configurația Laravel
        $this->defaultLocale = config('app.locale', 'en');
    }

    /**
     * Run the migrations.
     * Transformă coloana `slug` din `string` în `json`, păstrând datele existente.
     */
    public function up(): void
    {
        // Verificăm dacă coloana `slug` există și este de tip string
        // Această verificare este pentru siguranță, dar în contextul tău probabil știi că există.
        if (!Schema::hasColumn('blog_posts', 'slug')) {
            // Dacă nu există, nu avem ce modifica
            return;
        }

        // 1. Adăugăm o coloană temporară pentru a salva valorile vechi ale slug-ului
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('slug_temp_migration')->nullable();
        });

        // 2. Copiem valorile existente din `slug` în coloana temporară
        // Folosim `DB::raw` pentru a copia valoarea textuală direct.
        DB::table('blog_posts')->update(['slug_temp_migration' => DB::raw('"slug"')]);

        // 3. Ștergem vechea coloană `slug` (de tip string)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        // 4. Adăugăm coloana `slug` ca `json`
        // Nu adăugăm index `btree` direct pe `json` în PostgreSQL.
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('slug')->nullable(); // Inițial nullable pentru populare
        });

        // 5. Convertim valorile vechi din coloana temporară în format JSON
        // Ex: 'my-old-slug' -> {"en": "my-old-slug"}
        // Verificăm să nu lucrăm cu valori null sau empty
        DB::table('blog_posts')
            ->whereNotNull('slug_temp_migration')
            ->where('slug_temp_migration', '!=', '')
            ->update([
                'slug' => DB::raw("jsonb_build_object('{$this->defaultLocale}', \"slug_temp_migration\")")
            ]);

        // 6. Ștergem coloana temporară
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug_temp_migration');
        });

        // === OPȚIONAL: Adăugare index GIN pentru căutări rapide în JSON ===
        // Dacă vrei să cauți eficient în interiorul slug-urilor (ex: `WHERE slug->>'en' = 'value'`)
        // Schema::table('blog_posts', function (Blueprint $table) {
        //     $table->index(['slug'], 'blog_posts_slug_gin_index', 'gin');
        // });
        // ====================================================================
    }

    /**
     * Reverse the migrations.
     * Revenim la coloana `slug` de tip `string`.
     * ATENȚIE: Această operațiune poate duce la pierderi de date dacă ai slug-uri diferite pentru limbi diferite.
     */
    public function down(): void
    {
        // 1. (Opțional) Ștergem indexul GIN dacă l-am creat
        // if (Schema::hasIndex('blog_posts', 'blog_posts_slug_gin_index')) {
        //     Schema::table('blog_posts', function (Blueprint $table) {
        //         $table->dropIndex('blog_posts_slug_gin_index');
        //     });
        // }

        // 2. Adăugăm o coloană temporară pentru a salva slug-ul implicit
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('slug_down_temp')->nullable();
        });

        // 3. Extragem slug-ul implicit (ex: 'en') și îl salvăm în coloana temporară
        // Acest pas poate duce la pierderi de informații dacă ai slug-uri diferite pe limbi.
        DB::table('blog_posts')
            ->whereNotNull("slug") // Verificăm că slug-ul JSON nu e null
            ->update([
                'slug_down_temp' => DB::raw("slug->>'{$this->defaultLocale}'")
            ]);

        // 4. Ștergem vechea coloană `slug` (de tip json)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        // 5. Recreăm coloana `slug` ca `string` cu constrângerea `unique`
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('slug', 255)->unique()->nullable(); // Le facem nullable temporar
        });

        // 6. Copiem valorile din coloana temporară înapoi în `slug`
        DB::table('blog_posts')
            ->whereNotNull('slug_down_temp')
            ->update(['slug' => DB::raw('"slug_down_temp"')]);

        // 7. Ștergem coloana temporară
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug_down_temp');
        });

        // 8. (Opțional) Dacă vrei ca slug-ul să fie NOT NULL
        // Schema::table('blog_posts', function (Blueprint $table) {
        //     $table->string('slug', 255)->unique()->nullable(false)->change();
        // });
    }
};