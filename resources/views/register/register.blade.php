@extends('layout/default')
@section('content')
<section class="section">

    <h2 class="main-profile-title">Inscription</h2>

    <div class="register-box contact-box">
        {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
            @csrf
            <label class="label-input-username" for="input-username">Nom d'utilisateur</label>
            <input class="input-username" type="text" name="input-username" id="input-username"/>

            <label class="label-input-email" for="inputEmail">Email</label>
            <input class="input-email" type="text" name="inputEmail" id="input-email"/>

            <label class="label-input-address" for="inputAddress">Adresse</label>
            <input class="input-address" type="text" name="inputAddress" id="input-address"/>

            <label class="label-input-phone" for="inputPhone">Téléphone</label>
            <input class="input-phone" type="text" name="inputPhone" id="input-phone"/>

            <label class="label-input-password" for="inputPassword">Mot de passe</label>
            <input class="input-password" type="password" name="inputPassword" id="input-password" placeholder="Minimum: 6 caractères"/>

            <label class="label-input-password-confirm" for="inputPassword_confirmation">Confirmer</label>
            <input class="input-password-confirm" type="password" name="inputPassword_confirmation" id="input-password-confirm" placeholder="Minimum: 6 caractères"/>

            <button class="register-submit-button" type="submit" name="register-submit-button">Valider</button>
        {{ Form::close() }}
    </div>

    @if (session()->has('error'))
    <div class="error-message-box">
        <p class="error-message-p">{{ session()->get('error') }}</p>
    </div>
    @endif

</section>
@stop