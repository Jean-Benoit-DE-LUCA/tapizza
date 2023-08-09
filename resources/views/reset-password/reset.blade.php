@extends('layout/default')
@section('content')

<section class="section">

    <h2 class="main-profile-title">Entrer nouveau mot de passe</h2>

    @if (session()->has('error'))
    <div class="error-message-box error-message-box-reset">
        <p class="error-message-p">{{ session()->get('error') }}</p>
    </div>
    @endif

    <div class="register-box reset-password-box">
        {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
            @csrf

            <label class="label-input-password label-input-password-reset" for="inputPassword">Nouveau mot de passe</label>
            <input class="input-password" type="password" name="inputPassword" id="input-password"/>

            <label class="label-input-password-confirm label-input-password-reset" for="inputPassword_confirmation">Confirmer</label>
            <input class="input-password-confirm" type="password" name="inputPassword_confirmation" id="input-password-confirm"/>

            @if (isset($email))
                <input class="input-mail-hidden" type="hidden" name="input-mail-hidden" id="input-mail-hidden" value="{{ $email }}"/>
                <input class="input-token-hidden" type="hidden" name="input-token-hidden" id="input-token-hidden" value="{{ $tokenReset }}"/>
            @endif

            <button class="register-submit-button" type="submit" name="register-submit-button">Valider</button>

        {{ Form::close() }}
    </div>

</section>

@endsection