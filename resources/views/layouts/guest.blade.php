<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('auth_title')</title>

    <link href="{{ asset('backend/auth/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/auth/css/style.css') }}" rel="stylesheet">

</head>

<body>
<div class="container">
    <div class="card card-container">
        <a href="{{ route('login') }}">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        </a>

        {{ $slot }}
    </div><!-- /card-container -->
</div><!-- /container -->

<script src="{{ asset('backend/auth/js/bootstrap.min.js') }}"></script>
</body>
</html>

