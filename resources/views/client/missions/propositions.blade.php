@extends('layouts.app')
@section('title', 'Propositions reçues')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
            <h3 class="fw-bold mb-0">Propositions pour : {{ $mission->titre }}</h3>
            <small class="text-muted">
                Budget : {{ number_format($mission->budget_min) }}€ — {{ number_format($mission->budget_max) }}€
                &nbsp;|&nbsp; Deadline : {{ $mission->deadline->format('d/m/Y') }}
            </small>
        </div>
        <span class="badge bg-{{ match($mission->statut) {
            'ouverte'  => 'success',
            'en_cours' => 'warning',
            'terminee' => 'secondary',
            'annulee'  => 'danger',
            default    => 'light'
        } }} fs-6">
            {{ ucfirst($mission->statut) }}
        </span>
    </div>

    @forelse($mission->propositions as $prop)
    <div class="card p-4 mb-3">
        <div class="row align-items-center">
            {{-- Infos freelance --}}
            <div class="col-md-3 border-end">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center
                                text-white fw-bold flex-shrink-0"
                         style="width:42px;height:42px">
                        {{ strtoupper(substr($prop->freelance->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $prop->freelance->name }}</div>
                        <small class="text-muted">{{ $prop->freelance->country ?? '' }}</small>
                    </div>
                </div>
                @if($prop->freelance->profilFreelance)
                    <small class="text-muted d-block">
                        {{ $prop->freelance->profilFreelance->titre_professionnel }}
                    </small>
                    <div class="mt-1">
                        @foreach(array_slice($prop->freelance->profilFreelance->competences ?? [], 0, 3) as $comp)
                            <span class="badge bg-light text-dark border me-1 mb-1">{{ $comp }}</span>
                        @endforeach
                    </div>
                    <div class="mt-1">
                        <i class="bi bi-star-fill text-warning"></i>
                        <small>{{ $prop->freelance->profilFreelance->note_moyenne }}/5</small>
                    </div>
                @endif
                <a href="{{ route('freelances.show', $prop->freelance) }}"
                   class="btn btn-outline-secondary btn-sm mt-2 w-100">
                    Voir profil
                </a>
            </div>

            {{-- Détails proposition --}}
            <div class="col-md-6 px-4">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded p-2 text-center">
                            <div class="fw-bold text-success fs-5">{{ number_format($prop->montant) }}€</div>
                            <small class="text-muted">Montant proposé</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2 text-center">
                            <div class="fw-bold text-primary fs-5">{{ $prop->delai_jours }}j</div>
                            <small class="text-muted">Délai proposé</small>
                        </div>
                    </div>
                </div>
                <p class="text-muted small mb-0">{{ $prop->message }}</p>
            </div>

            {{-- Actions --}}
            <div class="col-md-3 text-center">
                @if($prop->statut === 'en_attente' && $mission->statut === 'ouverte')
                    <form method="POST"
                          action="{{ route('client.propositions.accepter', $prop) }}"
                          class="mb-2"
                          onsubmit="return confirm('Accepter cette proposition ?')">
                        @csrf @method('PATCH')
                        <button class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-1"></i>Accepter
                        </button>
                    </form>
                    <form method="POST"
                          action="{{ route('client.propositions.refuser', $prop) }}"
                          onsubmit="return confirm('Refuser cette proposition ?')">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger w-100 mb-2">
                            <i class="bi bi-x-circle me-1"></i>Refuser
                        </button>
                    </form>
                @else
                    <span class="badge fs-6 bg-{{ match($prop->statut) {
                        'acceptee'   => 'success',
                        'refusee'    => 'danger',
                        'en_attente' => 'warning',
                        default      => 'secondary'
                    } }}">
                        {{ ucfirst(str_replace('_',' ',$prop->statut)) }}
                    </span>
                @endif
                <a href="{{ route('messages.conversation', $prop->freelance) }}"
                   class="btn btn-outline-primary w-100 mt-2 btn-sm">
                    <i class="bi bi-chat-dots me-1"></i>Contacter
                </a>
            </div>
        </div>
    </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-3">Aucune proposition reçue pour cette mission.</p>
        </div>
    @endforelse
</div>
@endsection