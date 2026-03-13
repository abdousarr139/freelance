@extends('layouts.app')
@section('title', 'Dashboard Client')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 me-2 text-primary"></i>
            Bonjour, {{ auth()->user()->name }} 👋
        </h2>
        <a href="{{ route('client.missions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Publier une mission
        </a>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-primary border-4">
                <h3 class="fw-bold text-primary">{{ $stats['total_missions'] }}</h3>
                <small class="text-muted">Total missions</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-success border-4">
                <h3 class="fw-bold text-success">{{ $stats['missions_ouvertes'] }}</h3>
                <small class="text-muted">Ouvertes</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-warning border-4">
                <h3 class="fw-bold text-warning">{{ $stats['missions_en_cours'] }}</h3>
                <small class="text-muted">En cours</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-info border-4">
                <h3 class="fw-bold text-info">{{ $stats['total_propositions'] }}</h3>
                <small class="text-muted">Propositions reçues</small>
            </div>
        </div>
    </div>

    {{-- MISSIONS --}}
    <div class="card p-4">
        <h5 class="fw-bold mb-3">Mes missions</h5>
        @forelse($missions as $mission)
        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
            <div>
                <h6 class="fw-bold mb-1">{{ $mission->titre }}</h6>
                <div class="d-flex gap-2 small text-muted">
                    <span><i class="bi bi-tag me-1"></i>{{ $mission->category->nom }}</span>
                    <span><i class="bi bi-calendar me-1"></i>{{ $mission->deadline->format('d/m/Y') }}</span>
                    <span><i class="bi bi-people me-1"></i>{{ $mission->propositions->count() }} offres</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-{{ match($mission->statut) {
                    'ouverte'   => 'success',
                    'en_cours'  => 'warning',
                    'terminee'  => 'secondary',
                    'annulee'   => 'danger',
                    default     => 'light'
                } }}">
                    {{ ucfirst($mission->statut) }}
                </span>
                <a href="{{ route('client.missions.propositions', $mission) }}"
                   class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>Voir offres
                </a>
                <a href="{{ route('client.missions.edit', $mission) }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <form method="POST" action="{{ route('client.missions.destroy', $mission) }}"
                      onsubmit="return confirm('Supprimer cette mission ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Aucune mission publiée.</p>
                <a href="{{ route('client.missions.create') }}" class="btn btn-primary btn-sm">
                    Publier ma première mission
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection