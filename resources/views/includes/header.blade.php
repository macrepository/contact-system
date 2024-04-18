<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Contact System</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
            <div class="container container-fluid">
                <h2 class="navbar-brand">Contacts</h2>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto"> <!-- Changed to ms-auto for right alignment on all views -->
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'addContact' ? 'active' : 'text-decoration-underline text-primary' }}" href="{{ route('addContact') }}">Add Contact</a>
                                </li>
                                <span class="vr d-none d-lg-block"></span>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'contacts' ? 'active' : 'text-decoration-underline text-primary' }}" href="{{ route('contacts') }}">Contacts</a>
                                </li>
                                <span class="vr d-none d-lg-block"></span>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link text-decoration-underline text-primary">
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'login' ? 'active' : 'text-decoration-underline text-primary' }}" href="{{ route('login') }}">Login</a>
                                </li>
                                <span class="vr d-none d-lg-block"></span>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : 'text-decoration-underline text-primary' }}" href="{{ route('register') }}">Register</a>
                                </li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>