@extends('layouts.app')
@section('title', 'Publier une mission')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="fw-bold mb-4">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>Publier une mission
                </h3>
                <form method="POST" action="{{ route('client.missions.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre de la mission *</label>
                            <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre') }}" placeholder="ex: Créer un site e-commerce Laravel" required>
                            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Catégorie *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        data-type="{{ $cat->type }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nom }} ({{ ucfirst($cat->type) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type de contrat *</label>
                            <select name="type_contrat" class="form-select @error('type_contrat') is-invalid @enderror" required>
                                <option value="fixe"    {{ old('type_contrat') === 'fixe'    ? 'selected' : '' }}>Prix fixe</option>
                                <option value="horaire" {{ old('type_contrat') === 'horaire' ? 'selected' : '' }}>Taux horaire</option>
                            </select>
                            @error('type_contrat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Budget minimum (€) *</label>
                            <input type="number" name="budget_min" class="form-control @error('budget_min') is-invalid @enderror"
                                   value="{{ old('budget_min') }}" min="1" required>
                            @error('budget_min')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Budget maximum (€) *</label>
                            <input type="number" name="budget_max" class="form-control @error('budget_max') is-invalid @enderror"
                                   value="{{ old('budget_max') }}" min="1" required>
                            @error('budget_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Deadline *</label>
                            <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror"
                                   value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description détaillée * (min. 50 caractères)</label>
                            <textarea name="description" rows="6"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Décrivez votre projet en détail : objectifs, livrables attendus, technologies souhaitées..." required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Fichier joint (PDF, DOC — optionnel)</label>
                            <input type="file" name="fichier_joint"
                                   class="form-control @error('fichier_joint') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx">
                            @error('fichier_joint')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send me-2"></i>Publier la mission
                            </button>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection