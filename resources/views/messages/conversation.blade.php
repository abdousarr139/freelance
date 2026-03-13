@extends('layouts.app')
@section('title', 'Conversation avec '.$user->name)

@section('content')
<div class="container py-4" style="max-width:750px">
    <div class="card">
        {{-- Header conversation --}}
        <div class="card-header bg-white d-flex align-items-center gap-3 py-3">
            <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center
                        text-white fw-bold"
                 style="width:40px;height:40px">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <div>
                <strong>{{ $user->name }}</strong>
                <small class="d-block text-muted">{{ ucfirst($user->role) }}</small>
            </div>
        </div>

        {{-- Messages --}}
        <div class="card-body" style="height:450px;overflow-y:auto;" id="msgBox">
            @forelse($messages as $msg)
                @php $isMine = $msg->expediteur_id === auth()->id(); @endphp
                <div class="d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                    <div class="px-3 py-2 rounded-3 {{ $isMine ? 'bg-primary text-white' : 'bg-light text-dark' }}"
                         style="max-width:70%">
                        <p class="mb-1 small">{{ $msg->contenu }}</p>
                        <small class="{{ $isMine ? 'text-white-50' : 'text-muted' }}" style="font-size:.7rem">
                            {{ $msg->created_at->format('H:i') }}
                            @if($isMine)
                                &nbsp;<i class="bi bi-check{{ $msg->lu ? '2-all' : '' }}"></i>
                            @endif
                        </small>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-chat fs-1"></i>
                    <p class="mt-2">Démarrez la conversation !</p>
                </div>
            @endforelse
        </div>

        {{-- Formulaire envoi --}}
        <div class="card-footer bg-white">
            <form method="POST" action="{{ route('messages.send', $user) }}">
                @csrf
                <div class="d-flex gap-2">
                    <input type="text" name="contenu" class="form-control"
                           placeholder="Écrire un message..." required autocomplete="off">
                    <button class="btn btn-primary px-3">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-scroll vers le bas
    const box = document.getElementById('msgBox');
    box.scrollTop = box.scrollHeight;
</script>
@endpush