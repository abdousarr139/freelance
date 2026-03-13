@extends('layouts.app')
@section('title', 'Dashboard Freelance')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 me-2 text-success"></i>
            Bonjour, {{ auth()->user()->name }} 👋
        </h2>
        <a href="{{ route('freelance.profil.edit') }}" class="btn btn-outline-success">
            <i class="bi bi-person-gear me-2"></i>Mon profil
        </a>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-primary border-4">
                <h3 class="fw-bold text-primary">{{ $stats['total_propositions'] }}</h3>
                <small class="text-muted">Total propositions</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-warning border-4">
                <h3 class="fw-bold text-warning">{{ $stats['propositions_attente'] }}</h3>
                <small class="text-muted">En attente</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-success border-4">
                <h3 class="fw-bold text-success">{{ $stats['propositions_acceptees'] }}</h3>
                <small class="text-muted">Acceptées</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-start border-danger border-4">
                <h3 class="fw-bold text-danger">{{ $stats['propositions_refusees'] }}</h3>
                <small class="text-muted">Refusées</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- MES PROPOSITIONS --}}
        <div class="col-lg-7">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Mes propositions</h5>
                @forelse($propositions as $prop)
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1">
                            <a href="{{ route('missions.show', $prop->mission) }}" class="text-decoration-none">
                                {{ Str::limit($prop->mission->titre, 45) }}
                            </a>
                        </h6>
                        <span class="badge bg-{{ match($prop->statut) {
                            'en_attente' => 'warning',
                            'acceptee'   => 'success',
                            'refusee'    => 'danger',
                            default      => 'secondary'
                        } }}">
                            {{ ucfirst(str_replace('_', ' ', $prop->statut)) }}
                        </span>
                    </div>
                    <div class="small text-muted d-flex gap-3">
                        <span><i class="bi bi-cash me-1"></i>{{ number_format($prop->montant) }}€</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $prop->delai_jours }} jours</span>
                        <span><i class="bi bi-tag me-1"></i>{{ $prop->mission->category->nom }}</span>
                    </div>
                </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Aucune proposition envoyée.</p>
                        <a href="{{ route('missions.index') }}" class="btn btn-primary btn-sm">
                            Trouver des missions
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- MISSIONS DISPONIBLES --}}
        <div class="col-lg-5">
            <div class="card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Missions disponibles</h5>
                    <a href="{{ route('missions.index') }}" class="btn btn-outline-primary btn-sm">
                        Voir tout
                    </a>
                </div>
                @foreach($missionsDisponibles as $mission)
                <div class="border-bottom py-2">
                    <a href="{{ route('missions.show', $mission) }}"
                       class="text-decoration-none text-dark">
                        <h6 class="mb-1">{{ Str::limit($mission->titre, 40) }}</h6>
                        <div class="small text-muted d-flex gap-2">
                            <span class="text-success fw-semibold">
                                {{ number_format($mission->budget_min) }}€+
                            </span>
                            <span>{{ $mission->category->nom }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection