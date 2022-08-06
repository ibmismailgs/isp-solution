<x-guest-layout>
    @section('auth_title', 'Forgot the password')

    <p id="profile-name" class="profile-name-card"></p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form class="form-signin" action="{{ route('password.email') }}" method="POST">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="{{ __('Email address') }}" value="{{ old('email') }}" required autofocus>

        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
            {{ __('Email Password Reset Link') }}
        </button>
    </form><!-- /form -->

</x-guest-layout>
