@extends('layout/default')
@section('content')
<section class="section">

    <h2 class="main-profile-title">Connexion</h2>

    <div class="register-box connection-box">
        {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
            @csrf
            <label class="label-input-email" for="inputEmail">Email</label>
            <input class="input-email" type="text" name="inputEmail" id="input-email"/>

            <label class="label-input-password" for="inputPassword">Mot de passe</label>
            <input class="input-password" type="password" name="inputPassword" id="input-password"/>

            <button class="register-submit-button" type="submit" name="register-submit-button">Valider</button>

            <a href="/mail">
                <button class="forgot-password-button" type="button" name="forgot-password-button">Mot de passe oublié</button>
            </a>
        {{ Form::close() }}
    </div>

    @if (session()->has('error'))
    <div class="error-message-box">
        <p class="error-message-p">{{ session()->get('error') }}</p>
    </div>
    @endif

</section>
@stop