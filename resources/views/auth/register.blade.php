@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="auth-panel">
    <div class="auth-card">
        <img class="auth-logo" src="{{ asset('images/logo.jpg') }}" alt="Semicolon" width="52" height="52">
        <p class="eyebrow">Semicolon</p>
        <h1>Create account</h1>
        <p class="lede">Register to start organizing your tasks.</p>

        <form method="POST" action="{{ route('register') }}" class="stack-form">
            @csrf

            <label class="field">
                <span>Name</span>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="field">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="new-password">
                @error('password')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="field">
                <span>Confirm password</span>
                <input type="password" name="password_confirmation" required autocomplete="new-password">
            </label>

            <button type="submit" class="btn btn-primary btn-block">Create account</button>
        </form>

        <p class="auth-footer">
            Already registered?
            <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</section>
@endsection
