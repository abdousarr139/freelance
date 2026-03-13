@extends('layouts.app')
@section('title', $mission->titre)

@section('content')
<div class="container py-5">
    <div class="row g-4">

        {{-- COLONNE GAUCHE : Détails --}}
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary fs-6">{{ $mission->category->nom }}</span>
                    <span class="badge bg-success fs-6">{{ ucfirst($mission->statut) }}</span>
                </div>
                <h1 class="fw-bold h3">{{ $mission->titre }}</h1>
                <div class="d-flex gap-3 text-muted small my-3">
                    <span><i class="bi bi-person me-1"></i>{{ $mission->client->name }}</span>
                    <span><i class="bi bi-geo-alt me-1"></i>{{ $mission->client->country ?? 'N/A' }}</span>
                    <span><i class="bi bi-calendar me-1"></i>Publié {{ $mission->created_at->diffForHumans() }}</span>
                </div>
                <hr>
                <h5 class="fw-bold">Description</h5>
                <p style="white-space:pre-line">{{ $mission->description }}</p>

                @if($mission->fichier_joint)
                <a href="{{ asset('storage/'.$mission->fichier_joint) }}"
                   class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="bi bi-paperclip me-1"></i>Voir le fichier joint
                </a>
                @endif
            </div>

            {{-- FORMULAIRE PROPOSITION --}}
            @auth
                @if(auth()->user()->isFreelance() && $mission->statut === 'ouverte')
                    @if($dejaPropose)
                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Vous avez déjà soumis une proposition pour cette mission.
                        </div>
                    @else
                        <div class="card p-4 mt-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-send me-2 text-primary"></i>Soumettre une proposition
                            </h5>
                            <form method="POST"
                                  action="{{ route('freelance.propositions.store', $mission) }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Montant proposé (€)</label>
                                        <input type="number" name="montant" class="form-control"
                                               placeholder="ex: 800" min="1" required
                                               value="{{ old('montant') }}">
                                        @error('montant')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Délai (jours)</label>
                                        <input type="number" name="delai_jours" class="form-control"
                                               placeholder="ex: 14" min="1" required
                                               value="{{ old('delai_jours') }}">
                                        @error('delai_jours')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Message de motivation</label>
                                        <textarea name="message" class="form-control" rows="5"
                                                  placeholder="Décrivez votre approche, votre expérience..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary px-4">
                                            <i class="bi bi-send me-2"></i>Envoyer ma proposition
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif
            @else
                <div class="alert alert-warning mt-4">
                    <i class="bi bi-lock me-2"></i>
                    <a href="{{ route('login') }}">Connectez-vous</a> pour soumettre une proposition.
                </div>
            @endauth
        </div>

        {{-- COLONNE DROITE : Résumé --}}
        <div class="col-lg-4">
            <div class="card p-4 mb-3">
                <h5 class="fw-bold mb-3">Détails de la mission</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-cash-coin text-success me-2"></i>
                        <strong>Budget :</strong>
                        {{ number_format($mission->budget_min) }}€ — {{ number_format($mission->budget_max) }}€
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        <strong>Deadline :</strong> {{ $mission->deadline->format('d/m/Y') }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-file-text text-info me-2"></i>
                        <strong>Contrat :</strong> {{ ucfirst($mission->type_contrat) }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-people text-warning me-2"></i>
                        <strong>Propositions :</strong> {{ $mission->propositions->count() }}
                    </li>
                </ul>
            </div>

            {{-- Profil client --}}
            <div class="card p-4">
                <h5 class="fw-bold mb-3">À propos du client</h5>
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                         style="width:48px;height:48px;font-size:1.2rem">
                        {{ strtoupper(substr($mission->client->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $mission->client->name }}</div>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt me-1"></i>{{ $mission->client->country ?? 'N/A' }}
                        </small>
                    </div>
                </div>
                @auth
                    @if(!auth()->user()->isClient())
                    <a href="{{ route('messages.conversation', $mission->client) }}"
                       class="btn btn-outline-primary btn-sm w-100 mt-3">
                        <i class="bi bi-chat-dots me-1"></i>Contacter le client
                    </a>
                    @endif
                @endauth
            </div>
        </div>

    </div>
</div>
@endsection