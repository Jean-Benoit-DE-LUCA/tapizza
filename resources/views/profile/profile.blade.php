@extends('layout/default')
@section('content')

<main class="main">
    <h2 class="main-profile-title">Profil utilisateur</h2>

    @if (session()->has('error'))
        <div class="error-message-box error-message-box-auth">
            <p class="error-message-p">{{ session()->get('error') }}</p>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="error-message-box error-message-box-auth success-message-box">
            <p class="error-message-p">{{ session()->get('success') }}</p>
        </div>
    @endif

    <section class="section">

        <div class="register-box">
            {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
                @csrf
                <span class="span-username">Nom d'utilisateur</span>
                <span class="span-username-value">{{ $getUser[0]->username }}</span>

                <span class="span-email">Email</span>
                <span class="span-email-value">{{ $getUser[0]->email }}</span>

                <label class="label-input-address" for="inputAddress">Adresse</label>
                <input class="input-address" type="text" name="inputAddress" id="input-address" value="{{ $getUser[0]->address }}"/>

                <label class="label-input-phone" for="inputPhone">Téléphone</label>
                <input class="input-phone" type="text" name="inputPhone" id="input-phone" value="{{ $getUser[0]->phone }}"/>

                <label class="label-input-password" for="inputPassword">Mot de passe</label>
                <div class="input" placeholder="Entrez votre mot de passe habituel ou modifier le (Minimum: 6 caractères)">
                    <input class="input-password" type="password" name="inputPassword" id="input-password" placeholder=" "/>
                </div>

                <label class="label-input-password-confirm" for="inputPassword_confirmation">Confirmer</label>
                <div class="input" placeholder="Entrez votre mot de passe habituel ou modifier le (Minimum: 6 caractères)">
                    <input class="input-password-confirm" type="password" name="inputPassword_confirmation" id="input-password-confirm" placeholder=" "/>
                </div>

                <button class="register-submit-button" type="submit" name="register-submit-button">Modifier</button>
            {{ Form::close() }}
        </div>
        
    </section>

</main>

@endsection