<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_freelances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('titre_professionnel');
            $table->json('competences');
            $table->string('portfolio_url')->nullable();
            $table->decimal('tarif_journalier', 8, 2)->nullable();
            $table->integer('annees_experience')->default(0);
            $table->decimal('note_moyenne', 3, 2)->default(0.00);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_freelances');
    }
};