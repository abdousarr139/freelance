<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — FreelanceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6610f2 0%, #520dc2 50%, #3d0a91 100%);
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
            color: #6610f2;
            text-decoration: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #6610f2;
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
            background: linear-gradient(135deg, #6610f2, #520dc2);
            border: none;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,16,242,0.4);
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
                    <div class="my-3">
                        <div class="rounded-circle bg-purple d-inline-flex align-items-center
                                    justify-content-center"
                             style="width:64px;height:64px;background:#6610f2">
                            <i class="bi bi-key-fill text-white fs-2"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">Mot de passe oublié ?</h5>
                    <p class="text-muted small">
                        Entrez votre email — nous vous enverrons un lien de réinitialisation.
                    </p>
                </div>

                {{-- Message de confirmation --}}
                @if(session('status'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small">{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Adresse email</label>
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

                    <button type="submit" class="btn btn-reset w-100 text-white mb-3">
                        <i class="bi bi-send me-2"></i>Envoyer le lien
                    </button>

                    <div class="text-center small">
                        <a href="{{ route('login') }}" class="text-decoration-none"
                           style="color:#6610f2">
                            <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>