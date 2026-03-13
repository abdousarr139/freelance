@extends('layouts.app')
@section('title', 'Freelances disponibles')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Freelances disponibles</h2>

    {{-- RECHERCHE --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Rechercher par nom ou titre..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="disponible"
                       id="disponible" value="1"
                       {{ request('disponible') ? 'checked' : '' }}>
                <label class="form-check-label" for="disponible">
                    Disponibles uniquement
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Filtrer
            </button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('freelances.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x"></i>
            </a>
        </div>
    </form>

    {{-- LISTE --}}
    <div class="row g-4">
        @forelse($freelances as $freelance)
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center
                                text-white fw-bold flex-shrink-0"
                         style="width:52px;height:52px;font-size:1.3rem">
                        {{ strtoupper(substr($freelance->name,0,1)) }}
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ $freelance->name }}</h5>
                        <small class="text-muted">
                            {{ $freelance->profilFreelance->titre_professionnel }}
                        </small>
                    </div>
                </div>

                {{-- Note --}}
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-star-fill text-warning"></i>
                    <strong>{{ $freelance->profilFreelance->note_moyenne }}</strong>
                    <span class="text-muted small">/5</span>
                    @if($freelance->profilFreelance->disponible)
                        <span class="badge bg-success ms-auto">Disponible</span>
                    @else
                        <span class="badge bg-secondary ms-auto">Indisponible</span>
                    @endif
                </div>

                {{-- Compétences --}}
                <div class="mb-3">
                    @foreach(array_slice($freelance->profilFreelance->competences ?? [], 0, 4) as $comp)
                        <span class="badge bg-light text-dark border me-1 mb-1">{{ $comp }}</span>
                    @endforeach
                </div>

                {{-- Infos --}}
                <div class="small text-muted mb-3">
                    <i class="bi bi-geo-alt me-1"></i>{{ $freelance->country ?? 'N/A' }}
                    &nbsp;|&nbsp;
                    <i class="bi bi-briefcase me-1"></i>
                    {{ $freelance->profilFreelance->annees_experience }} ans exp.
                    @if($freelance->profilFreelance->tarif_journalier)
                        &nbsp;|&nbsp;
                        <i class="bi bi-cash me-1"></i>
                        {{ number_format($freelance->profilFreelance->tarif_journalier) }}€/j
                    @endif
                </div>

                <a href="{{ route('freelances.show', $freelance) }}"
                   class="btn btn-outline-success btn-sm w-100 mt-auto">
                    Voir le profil
                </a>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-people fs-1 text-muted"></i>
                <p class="text-muted mt-2">Aucun freelance trouvé.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $freelances->withQueryString()->links() }}
    </div>
</div>
@endsection