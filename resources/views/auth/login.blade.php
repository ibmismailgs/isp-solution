<x-guest-layout>
    @section('auth_title', 'login')

    <p id="profile-name" class="profile-name-card"></p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form class="form-signin" action="{{ route('login') }}" method="POST">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="{{ __('Email address') }}" value="{{ old('email') }}" required autofocus>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="{{ __('Password') }}" required autocomplete="current-password">

        <div id="remember" class="checkbox">
            <label>
                <input type="checkbox" value="remember-me" name="remember"> {{ __('Remember me') }}
            </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
            {{ __('Sign in') }}
        </button>
    </form><!-- /form -->

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forgot-password">
            {{ __('Forgot the password?') }}
        </a>
    @endif
</x-guest-layout>
