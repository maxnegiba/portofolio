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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('slug')->unique();
        $table->json('title');      // {"en":"E-commerce","ro":"Magazin online"}
        $table->json('description');
        $table->json('tech');       // ["Laravel","Vue"]
        $table->string('live_url')->nullable();
        $table->string('github_url')->nullable();
        $table->string('thumbnail')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
