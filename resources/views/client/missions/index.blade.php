@extends('layouts.app')
@section('title', 'Mes Missions')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-briefcase me-2 text-primary"></i>Mes Missions
        </h2>
        <a href="{{ route('client.missions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Publier une mission
        </a>
    </div>

    <div class="card">
        @forelse($missions as $mission)
        <div class="d-flex justify-content-between align-items-center border-bottom px-4 py-3">
            <div>
                <h6 class="fw-bold mb-1">{{ $mission->titre }}</h6>
                <div class="d-flex gap-3 small text-muted">
                    <span><i class="bi bi-tag me-1"></i>{{ $mission->category->nom }}</span>
                    <span><i class="bi bi-cash me-1"></i>{{ number_format($mission->budget_min) }}€ — {{ number_format($mission->budget_max) }}€</span>
                    <span><i class="bi bi-calendar me-1"></i>{{ $mission->deadline->format('d/m/Y') }}</span>
                    <span><i class="bi bi-people me-1"></i>{{ $mission->propositions->count() }} offres</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-{{ match($mission->statut) {
                    'ouverte'  => 'success',
                    'en_cours' => 'warning',
                    'terminee' => 'secondary',
                    'annulee'  => 'danger',
                    default    => 'light'
                } }}">
                    {{ ucfirst($mission->statut) }}
                </span>
                <a href="{{ route('client.missions.propositions', $mission) }}"
                   class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>Offres
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
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Aucune mission publiée.</p>
                <a href="{{ route('client.missions.create') }}" class="btn btn-primary btn-sm">
                    Publier ma première mission
                </a>
            </div>
        @endforelse

        @if($missions->hasPages())
        <div class="px-4 py-3">
            {{ $missions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection