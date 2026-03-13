<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — FreelanceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 50%, #084298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .auth-logo {
            font-size: 2rem;
            font-weight: 900;
            color: #0d6efd;
            text-decoration: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            transition: border-color .2s;
        }
        .form-control:focus {
            border-color: #0d6efd;
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
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 1rem;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13,110,253,0.4);
        }
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #adb5bd;
            font-size: .85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="auth-card card p-4 p-md-5">

                {{-- Logo --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="auth-logo">
                        <i class="bi bi-briefcase-fill me-2"></i>FreelanceHub
                    </a>
                    <h5 class="fw-bold mt-3 mb-1">Bon retour 👋</h5>
                    <p class="text-muted small">Connectez-vous à votre compte</p>
                </div>

                {{-- Session Status --}}
                @if(session('status'))
                    <div class="alert alert-success small py-2">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

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
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="small text-primary text-decoration-none">
                                    Oublié ?
                                </a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>
                            <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0;border:2px solid #e9ecef;border-left:none"
                                    onclick="togglePassword()">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Se souvenir --}}
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login btn-primary w-100 text-white mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </button>

                    <div class="divider mb-3">ou</div>

                    <div class="text-center small">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                            S'inscrire gratuitement
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pwd.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>