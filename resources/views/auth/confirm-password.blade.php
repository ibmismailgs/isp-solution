<x-guest-layout>
    @section('auth_title', 'Confirm password')

    <p id="profile-name" class="profile-name-card"></p>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form class="form-signin" action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="{{ __('Password') }}" required autocomplete="current-password">

        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
            {{ __('Email Password Reset Link') }}
        </button>
    </form><!-- /form -->

</x-guest-layout>
