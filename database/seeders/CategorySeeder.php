<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // --- Numérique ---
            [
                'nom'   => 'Développement Web',
                'slug'  => 'dev-web',
                'type'  => 'numerique',
                'icone' => 'bi-code-slash',
            ],
            [
                'nom'   => 'Design & UI/UX',
                'slug'  => 'design',
                'type'  => 'numerique',
                'icone' => 'bi-palette',
            ],
            [
                'nom'   => 'Rédaction & Traduction',
                'slug'  => 'redaction',
                'type'  => 'numerique',
                'icone' => 'bi-pencil',
            ],
            [
                'nom'   => 'Marketing Digital',
                'slug'  => 'marketing',
                'type'  => 'numerique',
                'icone' => 'bi-graph-up',
            ],
            [
                'nom'   => 'Vidéo & Montage',
                'slug'  => 'video',
                'type'  => 'numerique',
                'icone' => 'bi-camera-video',
            ],
            [
                'nom'   => 'Sécurité Informatique',
                'slug'  => 'securite',
                'type'  => 'numerique',
                'icone' => 'bi-shield-lock',
            ],

            // --- Service ---
            [
                'nom'   => 'Plomberie',
                'slug'  => 'plomberie',
                'type'  => 'service',
                'icone' => 'bi-tools',
            ],
            [
                'nom'   => 'Électricité',
                'slug'  => 'electricite',
                'type'  => 'service',
                'icone' => 'bi-lightning',
            ],
            [
                'nom'   => 'Jardinage',
                'slug'  => 'jardinage',
                'type'  => 'service',
                'icone' => 'bi-tree',
            ],
            [
                'nom'   => 'Déménagement',
                'slug'  => 'demenagement',
                'type'  => 'service',
                'icone' => 'bi-truck',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}