
@extends('layouts.app')
@section('title', $user->name)

@section('content')
<div class="container py-5">
    <div class="row g-4">

        {{-- COLONNE GAUCHE --}}
        <div class="col-lg-4">
            <div class="card p-4 text-center mb-3">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center
                            text-white fw-bold mx-auto mb-3"
                     style="width:80px;height:80px;font-size:2rem">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <h4 class="fw-bold">{{ $user->name }}</h4>
                <p class="text-muted mb-1">
                    {{ $user->profilFreelance->titre_professionnel }}
                </p>
                <div class="d-flex justify-content-center align-items-center gap-1 mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= round($user->profilFreelance->note_moyenne) ? '-fill' : '' }}
                                  text-warning"></i>
                    @endfor
                    <small class="text-muted ms-1">
                        ({{ $user->profilFreelance->note_moyenne }}/5)
                    </small>
                </div>

                @if($user->profilFreelance->disponible)
                    <span class="badge bg-success mb-3">✓ Disponible</span>
                @else
                    <span class="badge bg-secondary mb-3">✗ Indisponible</span>
                @endif

                @auth
                    @if(!auth()->user()->isFreelance())
                    <a href="{{ route('messages.conversation', $user) }}"
                       class="btn btn-success w-100">
                        <i class="bi bi-chat-dots me-2"></i>Contacter
                    </a>
                    @endif
                @endauth
            </div>

            <div class="card p-4">
                <h6 class="fw-bold mb-3">Informations</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        {{ $user->country ?? 'Non renseigné' }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-briefcase text-primary me-2"></i>
                        {{ $user->profilFreelance->annees_experience }} ans d'expérience
                    </li>
                    @if($user->profilFreelance->tarif_journalier)
                    <li class="mb-2">
                        <i class="bi bi-cash text-success me-2"></i>
                        {{ number_format($user->profilFreelance->tarif_journalier) }}€ / jour
                    </li>
                    @endif
                    @if($user->profilFreelance->portfolio_url)
                    <li class="mb-2">
                        <i class="bi bi-link-45deg text-info me-2"></i>
                        <a href="{{ $user->profilFreelance->portfolio_url }}"
                           target="_blank">Portfolio</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- COLONNE DROITE --}}
        <div class="col-lg-8">

            {{-- Bio --}}
            @if($user->bio)
            <div class="card p-4 mb-3">
                <h5 class="fw-bold mb-2">À propos</h5>
                <p class="text-muted mb-0">{{ $user->bio }}</p>
            </div>
            @endif

            {{-- Compétences --}}
            <div class="card p-4 mb-3">
                <h5 class="fw-bold mb-3">Compétences</h5>
                @foreach($user->profilFreelance->competences ?? [] as $comp)
                    <span class="badge bg-primary me-1 mb-1 p-2">{{ $comp }}</span>
                @endforeach
            </div>

            {{-- Avis --}}
            <div class="card p-4">
                <h5 class="fw-bold mb-3">
                    Avis clients ({{ $user->avisRecus->count() }})
                </h5>
                @forelse($user->avisRecus as $avis)
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between mb-1">
                        <strong>{{ $avis->auteur->name }}</strong>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $avis->note ? '-fill' : '' }}
                                          text-warning small"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted small mb-0">{{ $avis->commentaire }}</p>
                    <small class="text-muted">{{ $avis->created_at->format('d/m/Y') }}</small>
                </div>
                @empty
                    <p class="text-muted">Aucun avis pour l'instant.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection