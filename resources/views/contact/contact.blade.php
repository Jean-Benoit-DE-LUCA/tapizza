@extends('layout/default')
@section('content')

<main class="main">

    <h2 class="main-profile-title">Contact</h2>

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

    <div class="register-box">
        {{ Form::open(array('method' => 'POST', 'class' => 'register-form')) }}
            @csrf

            <label class="label-input-name" for="inputName">Nom</label>
            <input class="input-name" type="text" name="inputName" id="input-name"/>

            <label class="label-input-email" for="inputEmail">Email</label>
            <input class="input-email" type="text" name="inputEmail" id="input-email"/>

            <label class="label-textarea" for="textarea-contact">Message</label>
            <textarea class="textarea-contact" name="textareaContact" id="textarea-contact"></textarea>

            <button class="register-submit-button" type="submit" name="register-submit-button">Envoyer</button>
        {{ Form::close() }}
    </div>


</main>

@endsection