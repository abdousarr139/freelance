@extends('layouts.app')
@section('title', 'Gestion Missions')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-briefcase me-2 text-warning"></i>Gestion des missions
    </h2>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Client</th>
                        <th>Catégorie</th>
                        <th>Budget</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missions as $mission)
                    <tr>
                        <td>{{ $mission->id }}</td>
                        <td class="fw-semibold">
                            {{ Str::limit($mission->titre, 35) }}
                        </td>
                        <td class="small">{{ $mission->client->name }}</td>
                        <td class="small">{{ $mission->category->nom }}</td>
                        <td class="small text-success">
                            {{ number_format($mission->budget_min) }}€
                            — {{ number_format($mission->budget_max) }}€
                        </td>
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
                        <td class="small text-muted">
                            {{ $mission->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <form method="POST"
                                  action="{{ route('admin.missions.toggle', $mission) }}"
                                  class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-toggle-on"></i>
                                </button>
                            </form>
                            <form method="POST"
                                  action="{{ route('admin.missions.destroy', $mission) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $missions->links() }}
        </div>
    </div>
</div>
@endsection