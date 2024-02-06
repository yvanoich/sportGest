@extends('layouts.app')

@section('styles')
    <!-- Vos styles spécifiques pour cette vue -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier vos informations') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile-set') }}" enctype="multipart/form-data">
                        @csrf

                        <?php
                            $profileImagePath = public_path('images/profiles/' . $user->ident.'.jpg');
                        ?>

                        <div class="profile-image" style="@if(!is_file($profileImagePath)) display:none; @endif">
                            @if (is_file($profileImagePath))
                                <!-- Afficher l'image existante -->
                                <img id="existingImage" src="{{ asset('images/profiles/' . $user->ident.'.jpg') }}" alt="Image de profil">
                            @endif

                            <!-- Afficher l'image prévisualisée -->
                            <img id="previewImage" style="display: none;" alt="Aperçu de l'image">
                        </div>

                        <!-- Champ d'input pour téléverser une nouvelle image -->
                        <div class="input-file-container">  
                            <input class="input-file" id="profileImageInput" type="file" name="profile_image" onchange="readURL(this);">
                            <label tabindex="0" for="profileImageInput" class="input-file-trigger">Choisir un fichier...</label>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Pseudo') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adresse e-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmation mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if(isset($success))
                                    <div class="success-msg">{{ $success }}</div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mettre à jour') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
