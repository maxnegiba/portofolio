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
        // Verificăm dacă coloana slug este încă de tip string/varchar
        // Presupunem că este, deoarece altfel ai fi avut eroarea "column already exists" mai devreme
        // și pentru că eroarea inițială indica că se încearcă inserarea unui JSON într-un varchar(255).

        // 1. Adăugăm o coloană temporară pentru a salva valorile vechi
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('slug_temp_for_migration')->nullable();
        });

        // 2. Copiem valorile actuale din slug în slug_temp_for_migration
        // Presupunem că valorile actuale sunt string-uri simple (slug-uri globale)
        DB::table('blog_posts')->update(['slug_temp_for_migration' => DB::raw('"slug"')]);

        // 3. Ștergem vechea coloană slug (de tip string)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        // 4. Adăugăm coloana slug ca json
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('slug')->nullable(); // Inițial o lăsăm nullable pentru a umple datele
            $table->index('slug'); // Adăugăm index pentru performanță (opțional)
        });

        // 5. Convertim valorile vechi în format JSON
        // Presupunem că limba implicită este 'en'. Poți schimba această valoare.
        $defaultLocale = config('app.locale', 'en');

        // Actualizăm coloana slug cu valorile vechi transformate în JSON
        // Ex: 'my-old-slug' -> {"en": "my-old-slug"}
        // Verificăm să nu suprascriem slug-uri care ar putea fi deja json (dintr-o tentativă anterioară eșuată)
        DB::table('blog_posts')
            ->whereNotNull('slug_temp_for_migration')
            ->where('slug_temp_for_migration', '!=', '') // Ignorăm cele goale
            ->update([
                'slug' => DB::raw("jsonb_build_object('{$defaultLocale}', \"slug_temp_for_migration\")")
            ]);

        // 6. Ștergem coloana temporară
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug_temp_for_migration');
        });

        // 7. (Opțional) Dacă vrei ca slug-ul să fie obligatoriu în viitor:
        // Schema::table('blog_posts', function (Blueprint $table) {
        //     $table->json('slug')->nullable(false)->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenim la varianta anterioară: slug ca string unic
        Schema::table('blog_posts', function (Blueprint $table) {
            // Ștergem indexul dacă l-am creat
            $table->dropIndex(['slug']); // Ajustează numele indexului dacă e diferit
            // Ștergem coloana slug json
            $table->dropColumn('slug');
        });

        // Adăugăm înapoi coloana slug string
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('slug', 255)->unique();
            // Dacă aveai un index separat înainte de unique, adaugă-l aici
            // $table->index('slug');
        });

        // Nu vom încerca să reconstruim valorile vechi din JSON, pentru că procesul e ireversibil
        // dacă ai slug-uri diferite pentru limbi diferite. Va trebui să le regenerezi manual dacă e nevoie.
    }
};