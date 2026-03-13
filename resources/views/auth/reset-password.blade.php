<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — FreelanceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fd7e14 0%, #dc6502 50%, #b35309 100%);
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
            color: #fd7e14;
            text-decoration: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #fd7e14;
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
        .btn-reset {
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            background: linear-gradient(135deg, #fd7e14, #dc6502);
            border: none;
            transition: transform .2s;
        }
        .btn-reset:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="auth-card card p-4 p-md-5">

                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="auth-logo">
                        <i class="bi bi-briefcase-fill me-2"></i>FreelanceHub
                    </a>
                    <h5 class="fw-bold mt-3 mb-1">Nouveau mot de passe 🔐</h5>
                    <p class="text-muted small">Choisissez un nouveau mot de passe sécurisé</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $request->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Nouveau mot de passe --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" name="password" id="pwd"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 caractères"
                                   required>
                            <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0;border:2px solid #e9ecef;border-left:none"
                                    onclick="togglePwd('pwd','eye1')">
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
                            <input type="password" name="password_confirmation" id="pwd2"
                                   class="form-control"
                                   placeholder="Répétez le mot de passe"
                                   required>
                            <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0;border:2px solid #e9ecef;border-left:none"
                                    onclick="togglePwd('pwd2','eye2')">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-reset w-100 text-white mb-3">
                        <i class="bi bi-check-circle me-2"></i>Réinitialiser le mot de passe
                    </button>

                    <div class="text-center small">
                        <a href="{{ route('login') }}" class="text-decoration-none text-warning">
                            <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePwd(fieldId, iconId) {
    const f = document.getElementById(fieldId);
    const i = document.getElementById(iconId);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>