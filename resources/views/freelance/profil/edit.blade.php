@extends('layouts.app')
@section('title', 'Mon Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="fw-bold mb-4">
                    <i class="bi bi-person-gear me-2 text-success"></i>Mon Profil Freelance
                </h3>
                <form method="POST" action="{{ route('freelance.profil.update') }}"
                      enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <h6 class="fw-bold text-muted text-uppercase mb-3 mt-2">
                        Informations personnelles
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom complet</label>
                            <input type="text" class="form-control"
                                   value="{{ auth()->user()->name }}" disabled>
                            <small class="text-muted">Non modifiable ici</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pays</label>
                            <input type="text" name="country" class="form-control"
                                   value="{{ old('country', auth()->user()->country) }}"
                                   placeholder="ex: France">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   placeholder="+33 6 00 00 00 00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Photo de profil</label>
                            <input type="file" name="avatar" class="form-control"
                                   accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Bio</label>
                            <textarea name="bio" class="form-control" rows="3"
                                      placeholder="Parlez de vous en quelques mots...">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold text-muted text-uppercase mb-3">
                        Informations professionnelles
                    </h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre professionnel *</label>
                            <input type="text" name="titre_professionnel"
                                   class="form-control @error('titre_professionnel') is-invalid @enderror"
                                   value="{{ old('titre_professionnel', $profil->titre_professionnel ?? '') }}"
                                   placeholder="ex: Développeur Full Stack Laravel"
                                   required>
                            @error('titre_professionnel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Compétences * <small class="text-muted">(séparées par des virgules)</small>
                            </label>
                            <input type="text" name="competences"
                                   class="form-control @error('competences') is-invalid @enderror"
                                   value="{{ old('competences', implode(', ', $profil->competences ?? [])) }}"
                                   placeholder="Laravel, Vue.js, MySQL, Docker"
                                   required>
                            @error('competences')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tarif journalier (€)</label>
                            <input type="number" name="tarif_journalier" class="form-control"
                                   value="{{ old('tarif_journalier', $profil->tarif_journalier ?? '') }}"
                                   placeholder="ex: 150" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Années d'expérience *</label>
                            <input type="number" name="annees_experience"
                                   class="form-control"
                                   value="{{ old('annees_experience', $profil->annees_experience ?? 0) }}"
                                   min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">URL Portfolio</label>
                            <input type="url" name="portfolio_url" class="form-control"
                                   value="{{ old('portfolio_url', $profil->portfolio_url ?? '') }}"
                                   placeholder="https://monportfolio.com">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       name="disponible" id="disponible" value="1"
                                       {{ old('disponible', $profil->disponible ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="disponible">
                                    Je suis disponible pour de nouvelles missions
                                </label>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-2"></i>Enregistrer le profil
                            </button>
                            <a href="{{ route('freelance.dashboard') }}"
                               class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection