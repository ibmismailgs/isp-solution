<x-guest-layout>
    @section('auth_title', 'Reset Password')

    <p id="profile-name" class="profile-name-card"></p>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form class="form-signin" action="{{ route('password.update') }}" method="POST">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <span id="reauth-email" class="reauth-email"></span>

        <div class="form-group">
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="{{ __('Your E-mail') }}" required/>
        </div>

        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="{{ __('Password') }}" required/>
        </div>

        <div class="form-group">
            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('Password C onfirmation') }}" required/>
        </div>

        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
            {{ __('Reset Password') }}
        </button>
    </form><!-- /form -->

</x-guest-layout>
