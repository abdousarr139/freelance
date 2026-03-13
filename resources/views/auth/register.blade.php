<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — FreelanceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #198754 0%, #146c43 50%, #0f5132 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 30px 0;
        }
        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .auth-logo {
            font-size: 2rem;
            font-weight: 900;
            color: #198754;
            text-decoration: none;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            transition: border-color .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: none;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #e9ecef;
            border-right: none;
            background: #f8f9fa;
        }
        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }
        .btn-register {
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 1rem;
            background: linear-gradient(135deg, #198754, #146c43);
            border: none;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25,135,84,0.4);
        }
        .role-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all .2s;
        }
        .role-card:hover { border-color: #198754; background: #f0fff4; }
        .role-card.selected { border-color: #198754; background: #d1e7dd; }
        .role-card input { display: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="auth-card card p-4 p-md-5">

                {{-- Logo --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="auth-logo">
                        <i class="bi bi-briefcase-fill me-2"></i>FreelanceHub
                    </a>
                    <h5 class="fw-bold mt-3 mb-1">Créer un compte 🚀</h5>
                    <p class="text-muted small">Rejoignez notre communauté gratuitement</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Choix du rôle --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Je suis...</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="role-card d-block text-center {{ old('role','client') === 'client' ? 'selected' : '' }}"
                                       id="card-client" onclick="selectRole('client')">
                                    <input type="radio" name="role" value="client"
                                           {{ old('role','client') === 'client' ? 'checked' : '' }}>
                                    <i class="bi bi-person-tie fs-2 text-primary d-block mb-1"></i>
                                    <strong class="d-block">Client</strong>
                                    <small class="text-muted">Je publie des missions</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="role-card d-block text-center {{ old('role') === 'freelance' ? 'selected' : '' }}"
                                       id="card-freelance" onclick="selectRole('freelance')">
                                    <input type="radio" name="role" value="freelance"
                                           {{ old('role') === 'freelance' ? 'checked' : '' }}>
                                    <i class="bi bi-laptop fs-2 text-success d-block mb-1"></i>
                                    <strong class="d-block">Freelance</strong>
                                    <small class="text-muted">Je cherche des missions</small>
                                </label>
                            </div>
                        </div>
                        @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Jean Dupont"
                                   required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="votre@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pays --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pays</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-geo-alt text-muted"></i>
                            </span>
                            <input type="text" name="country"
                                   class="form-control"
                                   value="{{ old('country') }}"
                                   placeholder="ex: France, Tunisie...">
                        </div>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 caractères"
                                   required>
                            <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0;border:2px solid #e9ecef;border-left:none"
                                    onclick="togglePassword('password','eye1')">
                                <i class="bi bi-eye" id="eye1"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirmation --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill text-muted"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="password2"
                                   class="form-control"
                                   placeholder="Répétez le mot de passe"
                                   required>
                            <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0;border:2px solid #e9ecef;border-left:none"
                                    onclick="togglePassword('password2','eye2')">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register btn-success w-100 text-white mb-3">
                        <i class="bi bi-person-plus me-2"></i>Créer mon compte
                    </button>

                    <div class="text-center small">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">
                            Se connecter
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectRole(role) {
    document.getElementById('card-client').classList.remove('selected');
    document.getElementById('card-freelance').classList.remove('selected');
    document.getElementById('card-' + role).classList.add('selected');
    document.querySelector('input[value="' + role + '"]').checked = true;
}

function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>