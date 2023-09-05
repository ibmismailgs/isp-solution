<?php
    $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('auth_title')</title>

    <link href="{{ asset('backend/auth/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/auth/css/style.css') }}" rel="stylesheet">

    <style>
        body{
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgb(74, 71, 238) 0%, rgb(139, 0, 74) 35%, rgb(59, 154, 231) 100%);
        }

    </style>

</head>

<body>
<div class="container ">
    <div class="card card-container ">
        <img id="profile-img" class="profile-img-card" src="{{ asset('img/profile.png') }}" />

        {{ $slot }}
    </div><!-- /card-container -->
</div><!-- /container -->

<script src="{{ asset('backend/auth/js/bootstrap.min.js') }}"></script>
</body>
</html>

