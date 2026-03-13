@extends('layouts.app')
@section('title', 'Messages')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-chat-dots me-2 text-primary"></i>Mes conversations
    </h2>

    @forelse($conversations as $userId => $msgs)
        @php
            $lastMsg    = $msgs->first();
            $other      = $lastMsg->expediteur_id === auth()->id()
                          ? $lastMsg->destinataire
                          : $lastMsg->expediteur;
            $unreadCount = $msgs->where('destinataire_id', auth()->id())
                                ->where('lu', false)->count();
        @endphp
        <a href="{{ route('messages.conversation', $other) }}"
           class="card p-3 mb-2 text-decoration-none text-dark
                  {{ $unreadCount > 0 ? 'border-primary border-2' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center
                            text-white fw-bold flex-shrink-0"
                     style="width:44px;height:44px">
                    {{ strtoupper(substr($other->name,0,1)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $other->name }}</strong>
                        <small class="text-muted">
                            {{ $lastMsg->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <small class="text-muted">
                        {{ Str::limit($lastMsg->contenu, 60) }}
                    </small>
                </div>
                @if($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                @endif
            </div>
        </a>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-chat-dots fs-1 text-muted"></i>
            <p class="text-muted mt-3">Aucune conversation pour l'instant.</p>
        </div>
    @endforelse
</div>
@endsection