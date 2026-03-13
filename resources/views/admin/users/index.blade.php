@extends('layouts.app')
@section('title', 'Gestion Utilisateurs')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-people me-2 text-primary"></i>Gestion des utilisateurs
    </h2>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Pays</th>
                        <th>Inscrit le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td class="text-muted small">{{ $user->email }}</td>
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
                        <td class="small">{{ $user->country ?? '—' }}</td>
                        <td class="small text-muted">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            @if(!$user->isAdmin())
                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection