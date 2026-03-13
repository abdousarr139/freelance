@extends('layouts.app')
@section('title', 'FreelanceHub — Accueil')

@section('content')

{{-- HERO --}}
<section class="bg-dark text-white py-5">
    <div class="container py-4 text-center">
        <h1 class="display-4 fw-bold">Trouvez le bon freelance<br>pour votre projet</h1>
        <p class="lead text-muted mt-3">Numérique & Services — Rapide, fiable, professionnel</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('missions.index') }}" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-search me-2"></i>Voir les missions
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-person-plus me-2"></i>S'inscrire
            </a>
            @endguest
        </div>
        {{-- Stats --}}
        <div class="row justify-content-center mt-5 g-4">
            <div class="col-auto">
                <h3 class="fw-bold text-primary">{{ $stats['missions'] }}+</h3>
                <p class="text-muted small">Missions publiées</p>
            </div>
            <div class="col-auto">
                <h3 class="fw-bold text-success">{{ $stats['freelances'] }}+</h3>
                <p class="text-muted small">Freelances inscrits</p>
            </div>
            <div class="col-auto">
                <h3 class="fw-bold text-warning">{{ $stats['clients'] }}+</h3>
                <p class="text-muted small">Clients actifs</p>
            </div>
        </div>
    </div>
</section>

{{-- CATÉGORIES --}}
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Explorez par catégorie</h2>
        <div class="row g-3">
            @foreach($categories as $cat)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('missions.index', ['category_id' => $cat->id]) }}"
                   class="card text-center p-3 text-decoration-none text-dark h-100">
                    <i class="bi {{ $cat->icone }} fs-2 text-primary mb-2"></i>
                    <small class="fw-semibold">{{ $cat->nom }}</small>
                    <small class="text-muted">{{ $cat->missions_count }} missions</small>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MISSIONS RÉCENTES --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Missions récentes</h2>
            <a href="{{ route('missions.index') }}" class="btn btn-outline-primary btn-sm">
                Voir tout <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($missions as $mission)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary">{{ $mission->category->nom }}</span>
                        <span class="badge bg-{{ $mission->type_contrat === 'fixe' ? 'success' : 'info' }}">
                            {{ ucfirst($mission->type_contrat) }}
                        </span>
                    </div>
                    <h5 class="fw-bold">{{ Str::limit($mission->titre, 50) }}</h5>
                    <p class="text-muted small">{{ Str::limit($mission->description, 100) }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success">
                                {{ number_format($mission->budget_min) }}€
                                — {{ number_format($mission->budget_max) }}€
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                {{ $mission->deadline->diffForHumans() }}
                            </small>
                        </div>
                        <a href="{{ route('missions.show', $mission) }}"
                           class="btn btn-outline-primary btn-sm w-100 mt-2">
                            Voir la mission
                        </a>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-muted text-center">Aucune mission disponible pour l'instant.</p>
            @endforelse
        </div>
    </div>
</section>

@endsection