<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tasks') — {{ config('app.name', 'Semicolon') }}</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="page">
        <header class="topbar">
            <a class="brand" href="{{ url('/') }}">
                <img class="brand-logo" src="{{ asset('images/logo.jpg') }}" alt="Semicolon" width="40" height="40">
                <span class="brand-text">Semicolon</span>
            </a>
            @auth
                <div class="topbar-actions">
                    <span class="user-chip">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost">Log out</button>
                    </form>
                </div>
            @endauth
        </header>

        <main class="main">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
