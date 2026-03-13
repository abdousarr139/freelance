@extends('layouts.app')
@section('title', 'Modifier la mission')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="fw-bold mb-4">
                    <i class="bi bi-pencil me-2 text-warning"></i>Modifier la mission
                </h3>
                <form method="POST" action="{{ route('client.missions.update', $mission) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre *</label>
                            <input type="text" name="titre"
                                   class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre', $mission->titre) }}" required>
                            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Catégorie *</label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $mission->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type de contrat *</label>
                            <select name="type_contrat" class="form-select" required>
                                <option value="fixe"
                                    {{ old('type_contrat', $mission->type_contrat) === 'fixe' ? 'selected' : '' }}>
                                    Prix fixe
                                </option>
                                <option value="horaire"
                                    {{ old('type_contrat', $mission->type_contrat) === 'horaire' ? 'selected' : '' }}>
                                    Taux horaire
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Budget minimum (€) *</label>
                            <input type="number" name="budget_min" class="form-control"
                                   value="{{ old('budget_min', $mission->budget_min) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Budget maximum (€) *</label>
                            <input type="number" name="budget_max" class="form-control"
                                   value="{{ old('budget_max', $mission->budget_max) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Deadline *</label>
                            <input type="date" name="deadline" class="form-control"
                                   value="{{ old('deadline', $mission->deadline->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea name="description" rows="6" class="form-control" required>{{ old('description', $mission->description) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="bi bi-save me-2"></i>Enregistrer
                            </button>
                            <a href="{{ route('client.dashboard') }}"
                               class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection