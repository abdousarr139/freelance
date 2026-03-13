<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FreelanceHub')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; }
        .badge-role-client   { background:#0d6efd; }
        .badge-role-freelance{ background:#198754; }
        .card { border:none; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        .card:hover { box-shadow:0 4px 16px rgba(0,0,0,.13); transition:.2s; }
        .sidebar { min-height: 100vh; background:#212529; }
        .sidebar .nav-link { color:#adb5bd; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color:#fff; background:rgba(255,255,255,.1); border-radius:8px; }
        .sidebar .nav-link i { width: 20px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary" href="{{ route('home') }}">
            <i class="bi bi-briefcase-fill me-1"></i>FreelanceHub
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('missions.index') }}">
                        <i class="bi bi-search me-1"></i>Missions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('freelances.index') }}">
                        <i class="bi bi-people me-1"></i>Freelances
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @else
                    {{-- Notifications messages --}}
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative" href="{{ route('messages.index') }}">
                            <i class="bi bi-chat-dots fs-5"></i>
                            @php $unread = auth()->user()->messagesRecus()->where('lu',false)->count(); @endphp
                            @if($unread > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unread }}
                                </span>
                            @endif
                        </a>
                    </li>
                    {{-- Dropdown utilisateur --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:32px;height:32px;font-size:.9rem">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </div>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @if(auth()->user()->isClient())
                                <li><a class="dropdown-item" href="{{ route('client.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('client.missions.create') }}">
                                    <i class="bi bi-plus-circle me-2"></i>Publier une mission
                                </a></li>
                            @elseif(auth()->user()->isFreelance())
                                <li><a class="dropdown-item" href="{{ route('freelance.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('freelance.profil.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i>Mon Profil
                                </a></li>
                            @elseif(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-check me-2"></i>Admin Panel
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- MESSAGES FLASH --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
        <div class="container">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert">
        <div class="container">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

{{-- CONTENU --}}
@yield('content')

{{-- FOOTER --}}
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container text-center">
        <p class="mb-0 text-muted">
            &copy; {{ date('Y') }} FreelanceHub — Plateforme de recrutement freelance
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>