@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<section class="auth-panel">
    <div class="auth-card">
        <img class="auth-logo" src="{{ asset('images/logo.jpg') }}" alt="Semicolon" width="52" height="52">
        <p class="eyebrow">Semicolon</p>
        <h1>Log in</h1>
        <p class="lede">Sign in to manage your tasks.</p>

        <form method="POST" action="{{ route('login') }}" class="stack-form">
            @csrf

            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="field">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="current-password">
                @error('password')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="checkbox-row">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </form>

        <p class="auth-footer">
            No account?
            <a href="{{ route('register') }}">Create one</a>
        </p>
    </div>
</section>
@endsection
