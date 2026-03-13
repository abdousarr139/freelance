@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-shield-check me-2 text-danger"></i>Panel Administrateur
    </h2>

    {{-- STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-primary">{{ $stats['total_users'] }}</h3>
                <small class="text-muted">Utilisateurs</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-info">{{ $stats['total_clients'] }}</h3>
                <small class="text-muted">Clients</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-success">{{ $stats['total_freelances'] }}</h3>
                <small class="text-muted">Freelances</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-warning">{{ $stats['total_missions'] }}</h3>
                <small class="text-muted">Missions</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-success">{{ $stats['missions_ouvertes'] }}</h3>
                <small class="text-muted">Ouvertes</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-secondary">{{ $stats['total_propositions'] }}</h3>
                <small class="text-muted">Propositions</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- DERNIERS UTILISATEURS --}}
        <div class="col-lg-6">
            <div class="card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Derniers inscrits</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">
                        Gérer
                    </a>
                </div>
                <table class="table table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th><th>Email</th><th>Rôle</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($derniers_users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td class="small text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ match($user->role) {
                                    'admin'    => 'danger',
                                    'client'   => 'primary',
                                    'freelance'=> 'success',
                                    default    => 'secondary'
                                } }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DERNIÈRES MISSIONS --}}
        <div class="col-lg-6">
            <div class="card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Dernières missions</h5>
                    <a href="{{ route('admin.missions.index') }}" class="btn btn-outline-primary btn-sm">
                        Gérer
                    </a>
                </div>
                <table class="table table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Titre</th><th>Client</th><th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dernieres_missions as $mission)
                        <tr>
                            <td>{{ Str::limit($mission->titre, 30) }}</td>
                            <td class="small text-muted">{{ $mission->client->name }}</td>
                            <td>
                                <span class="badge bg-{{ match($mission->statut) {
                                    'ouverte'  => 'success',
                                    'en_cours' => 'warning',
                                    'terminee' => 'secondary',
                                    'annulee'  => 'danger',
                                    default    => 'light'
                                } }}">
                                    {{ ucfirst($mission->statut) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection