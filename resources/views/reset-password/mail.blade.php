@extends('layout/default')
@section('content')
<section class="section">

    <h2 class="main-profile-title">Réinitialiser mot de passe</h2>

    @if (session()->has('error'))
        <div class="error-message-box error-message-box-auth error-message-box-mail">
            <p class="error-message-p">{{ session()->get('error') }}</p>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="error-message-box error-message-box-auth success-message-box">
            <p class="error-message-p">{{ session()->get('success') }}</p>
        </div>
    @endif

    <div class="register-box mail-password-box">
        {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
            @csrf

            <label class="label-input-email" for="inputEmail">Email</label>
            <input class="input-email" type="email" name="inputEmail" id="input-email"/>

            <button class="mail-password-button" type="submit" name="mail-password-button">Envoyer email de réinitialisation</button>
        {{ Form::close() }}
    </div>
</section>
@endsection