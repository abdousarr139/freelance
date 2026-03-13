<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilFreelance;
use App\Models\Mission;
use App\Models\Proposition;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin ----
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
            'country'  => 'France',
        ]);

        // ---- Client 1 ----
        $client1 = User::create([
            'name'     => 'Jean Dupont',
            'email'    => 'client@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'client',
            'bio'      => 'Chef de projet digital, je cherche des freelances talentueux.',
            'phone'    => '+33 6 12 34 56 78',
            'country'  => 'France',
        ]);

        // ---- Client 2 ----
        $client2 = User::create([
            'name'     => 'Marie Martin',
            'email'    => 'client2@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'client',
            'bio'      => 'Entrepreneuse dans le e-commerce.',
            'phone'    => '+33 6 98 76 54 32',
            'country'  => 'Belgique',
        ]);

        // ---- Freelance 1 ----
        $freelance1 = User::create([
            'name'     => 'Ali Ben Salem',
            'email'    => 'freelance@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'freelance',
            'bio'      => 'Développeur Full Stack avec 5 ans d\'expérience.',
            'phone'    => '+216 55 123 456',
            'country'  => 'Tunisie',
        ]);

        ProfilFreelance::create([
            'user_id'              => $freelance1->id,
            'titre_professionnel'  => 'Développeur Full Stack Laravel / Vue.js',
            'competences'          => ['Laravel', 'Vue.js', 'MySQL', 'Docker', 'REST API'],
            'portfolio_url'        => 'https://alibensalem.dev',
            'tarif_journalier'     => 150.00,
            'annees_experience'    => 5,
            'note_moyenne'         => 4.80,
            'disponible'           => true,
        ]);

        // ---- Freelance 2 ----
        $freelance2 = User::create([
            'name'     => 'Sara Kone',
            'email'    => 'freelance2@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'freelance',
            'bio'      => 'Designer UI/UX passionnée par l\'expérience utilisateur.',
            'phone'    => '+225 07 123 456',
            'country'  => 'Côte d\'Ivoire',
        ]);

        ProfilFreelance::create([
            'user_id'             => $freelance2->id,
            'titre_professionnel' => 'Designer UI/UX & Graphiste',
            'competences'         => ['Figma', 'Adobe XD', 'Illustrator', 'Photoshop'],
            'portfolio_url'       => 'https://sarakone.design',
            'tarif_journalier'    => 120.00,
            'annees_experience'   => 3,
            'note_moyenne'        => 4.60,
            'disponible'          => true,
        ]);

        // ---- Missions de test ----
        $mission1 = Mission::create([
            'client_id'    => $client1->id,
            'category_id'  => 1, // Développement Web
            'titre'        => 'Créer un site e-commerce avec Laravel',
            'description'  => 'Je cherche un développeur pour créer une boutique en ligne complète avec panier, paiement Stripe et espace admin.',
            'budget_min'   => 500.00,
            'budget_max'   => 1500.00,
            'deadline'     => now()->addDays(30),
            'statut'       => 'ouverte',
            'type_contrat' => 'fixe',
        ]);

        $mission2 = Mission::create([
            'client_id'    => $client2->id,
            'category_id'  => 2, // Design
            'titre'        => 'Refonte graphique de mon application mobile',
            'description'  => 'Mon app iOS/Android a besoin d\'une refonte complète UI/UX. Livraison des maquettes Figma attendue.',
            'budget_min'   => 300.00,
            'budget_max'   => 800.00,
            'deadline'     => now()->addDays(15),
            'statut'       => 'ouverte',
            'type_contrat' => 'fixe',
        ]);

        // ---- Propositions de test ----
        Proposition::create([
            'mission_id'   => $mission1->id,
            'freelance_id' => $freelance1->id,
            'montant'      => 1200.00,
            'delai_jours'  => 25,
            'message'      => 'Bonjour, j\'ai développé plusieurs boutiques Laravel. Je peux livrer en 25 jours avec tous les modules demandés.',
            'statut'       => 'en_attente',
        ]);

        Proposition::create([
            'mission_id'   => $mission2->id,
            'freelance_id' => $freelance2->id,
            'montant'      => 650.00,
            'delai_jours'  => 12,
            'message'      => 'Bonjour, j\'ai une solide expérience en refonte UI mobile. Je livre les maquettes Figma complètes.',
            'statut'       => 'en_attente',
        ]);
    }
}