<?PHP
// In `database/migrations/xxxx_xx_xx_xxxxxx_update_blog_posts_table_increase_column_lengths.php`
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Modifică coloanele care sunt prea scurte
            $table->text('content')->change(); // Dacă nu merge direct, vezi mai jos
            $table->string('excerpt', 1000)->change();
            $table->string('meta_description', 1000)->change();
            // Dacă ai alte coloane cu probleme, le modifici aici
        });
    }

    public function down()
    {
         // În PostgreSQL, modificarea coloanelor poate necesita pași suplimentari.
         // O variantă mai sigură este recrearea coloanei.
         // Simplificat:
        Schema::table('blog_posts', function (Blueprint $table) {
            // Revenirea la starea anterioară necesită cunoașterea stării anterioare exacte
            // Acest exemplu este generic
            // $table->string('content', 255)->change(); // Presupunând că era 255
            // etc.
        });
    }
};