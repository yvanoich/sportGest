@extends('layouts.app')

@section('styles')
    <!-- Vos styles spécifiques pour cette vue -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="container-middle">
        <form method="POST" action="{{ route('activity-set', ['ident' => isset($activity->ident) ? $activity->ident : null]) }}">
            @csrf

            <div class="card-header">{{ __('Saisie de votre activité') }}</div>

            <div class="row">
                <div class="row-item-title">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nom de l\'activité') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $activity->name ?? '' }}" required placeholder="Mon activité">
                    </div>
                </div>
                <div class="row-item">
                    <div class="container-date">
                        <div class="bloc-date">
                            <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>
                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $date ?? now()->toDateString() }}" required>
                            </div>
                        </div>
                        <div class="bloc-time">
                            <label for="time" class="last-label col-md-4 col-form-label text-md-end">{{ __('Heure') }}</label>
                            <div class="col-md-6">
                                <input id="time" type="time" class="last-input form-control @error('time') is-invalid @enderror" name="time" value="{{ $time ?? now()->format('H:i') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row-item">
                    <label for="distance" class="col-md-4 col-form-label text-md-end">{{ __('Distance (km)') }}</label>

                    <div class="col-md-6">
                        <input id="distance" type="text" class="form-control @error('distance') is-invalid @enderror" name="distance" value="{{ $activity->distance ?? '' }}" required placeholder="10,5">
                    </div>
                </div>
                <div class="row-item">
                    <label for="duration" class="col-md-4 col-form-label text-md-end">{{ __('Durée (s)') }}</label>

                    <div class="activity-set-duration">
                        <div class="duration-input">
                            <input id="hours" type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ $hours ?? '' }}" placeholder="Heure(s)">
                        </div>
                        <div class="duration-input">
                            <input id="minutes" type="text" class="form-control @error('minutes') is-invalid @enderror" name="minutes" value="{{ $minutes ?? '' }}" placeholder="minute(s)">
                        </div>
                        <div class="duration-input">
                            <input id="secondes" type="text" class="form-control @error('secondes') is-invalid @enderror" name="secondes" value="{{ $secondes ?? '' }}" placeholder="seconde(s)">
                        </div>
                    </div>
                </div>
                <div class="row-item">
                    <label for="height" class="col-md-4 col-form-label text-md-end">{{ __('Dénivelé (m)') }}</label>

                    <div class="col-md-6">
                        <input id="height" type="text" class="form-control @error('height') is-invalid @enderror" name="height" value="{{ $activity->height ?? '' }}" placeholder="200">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row-item">
                <label for="sport" class="col-md-4 col-form-label text-md-end">{{ __('Sport') }}</label>
                    <select name="sport">
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->ident }}" @if(optional($activity)->sport == $sport->ident) selected @endif >{{ $sport->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="row-textarea">
                    <label for="distance" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                    <div class="col-md-6">
                        <textarea name="description">{{ $activity->description ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-submit">
                    @error('name')
                        <div class="invalid-feedback error-msg" role="alert">
                            Nom incorrect.
                        </div>
                    @enderror

                    @error('date')
                        <div class="invalid-feedback error-msg" role="alert">
                            Date incorrect.
                        </div>
                    @enderror

                    @error('time')
                        <div class="invalid-feedback error-msg" role="alert">
                            Heure incorrect.
                        </div>
                    @enderror

                    @error('distance')
                        <div class="invalid-feedback error-msg" role="alert">
                            Distance incorrecte.
                        </div>
                    @enderror
                    
                    @error('duration')
                        <div class="invalid-feedback error-msg" role="alert">
                            Durée incorrecte.
                        </div>
                    @enderror

                    @error('height')
                        <div class="invalid-feedback error-msg" role="alert">
                            Dénivelé incorrecte.
                        </div>
                    @enderror

                    @error('sport')
                        <div class="invalid-feedback error-msg" role="alert">
                            Sport incorrect.
                        </div>
                    @enderror

                    @error('description')
                        <div class="invalid-feedback error-msg" role="alert">
                            Description incorrect.
                        </div>
                    @enderror
                    <button type="submit" class="btn btn-primary">
                        {{ optional($activity)->ident ? __('Mettre à jour') : __('Créer') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
