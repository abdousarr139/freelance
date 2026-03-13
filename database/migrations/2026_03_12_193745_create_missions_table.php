<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->decimal('budget_min', 10, 2);
            $table->decimal('budget_max', 10, 2);
            $table->date('deadline');
            $table->enum('statut', ['ouverte','en_cours','terminee','annulee'])
                  ->default('ouverte');
            $table->enum('type_contrat', ['fixe','horaire']);
            $table->string('fichier_joint')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};