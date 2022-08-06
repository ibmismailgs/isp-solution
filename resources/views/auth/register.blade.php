<x-guest-layout>
    @section('auth_title', 'Register')

    <p id="profile-name" class="profile-name-card"></p>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form class="form-signin" action="{{ route('register') }}" method="POST">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>

        <div class="form-group">
            <input name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Your Name') }}" autofocus required/>
        </div>

        <div class="form-group">
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="{{ __('Your E-mail') }}" required/>
        </div>

        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="{{ __('Password') }}" required/>
        </div>

        <div class="form-group">
            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('Password Confirmation') }}" required/>
        </div>

        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
            {{ __('Register') }}
        </button>
    </form><!-- /form -->

    <a href="{{ route('login') }}" class="forgot-password">
        {{ __('Already registered??') }}
    </a>
</x-guest-layout>
