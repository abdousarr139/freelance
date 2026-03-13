@extends('layouts.app')
@section('title', 'Missions disponibles')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Missions disponibles</h2>

    {{-- FILTRES --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                   placeholder="Rechercher..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">Tous les types</option>
                <option value="numerique" {{ request('type') === 'numerique' ? 'selected' : '' }}>Numérique</option>
                <option value="service"   {{ request('type') === 'service'   ? 'selected' : '' }}>Service</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Filtrer
            </button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('missions.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x"></i>
            </a>
        </div>
    </form>

    {{-- LISTE --}}
    <div class="row g-4">
        @forelse($missions as $mission)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-primary">{{ $mission->category->nom }}</span>
                    <span class="badge bg-{{ $mission->category->type === 'numerique' ? 'info' : 'warning' }} text-dark">
                        {{ ucfirst($mission->category->type) }}
                    </span>
                </div>
                <h5 class="fw-bold">{{ Str::limit($mission->titre, 55) }}</h5>
                <p class="text-muted small flex-grow-1">
                    {{ Str::limit($mission->description, 110) }}
                </p>
                <div class="border-top pt-2 mt-2">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span><i class="bi bi-person me-1"></i>{{ $mission->client->name }}</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $mission->deadline->diffForHumans() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-success">
                            {{ number_format($mission->budget_min) }}€ — {{ number_format($mission->budget_max) }}€
                        </span>
                        <span class="badge bg-light text-dark border">
                            {{ $mission->propositions->count() }} offres
                        </span>
                    </div>
                    <a href="{{ route('missions.show', $mission) }}"
                       class="btn btn-outline-primary btn-sm w-100 mt-2">
                        Voir la mission
                    </a>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Aucune mission trouvée.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $missions->withQueryString()->links() }}
    </div>
</div>
@endsection